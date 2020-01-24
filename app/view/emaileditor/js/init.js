const accessKey = document.getElementById('access_key').value;
const action = document.getElementById('action').value;
const templateId = document.getElementById('templateId').value;
const emailId = document.getElementById('emailId').value;
const save = document.getElementById('save');
const preview = document.getElementById('preview');
const backPreview = document.getElementById('back-preview');
const testEmail = document.getElementById('test-email');
const controlPanel = document.getElementById('control-panel');

loading();
window.onload = () => {
    console.log('%c Document ready...', 'color: green; font-weight: bold');
    
    $('[data-toggle="tooltip"]').tooltip();

    /** on click button */
        save.addEventListener('click', onClickSave);
        preview.addEventListener('click', onClickPreview);
        backPreview.addEventListener('click', onClickBackPreview);
        testEmail.addEventListener('click', onClickTestEmail);
        controlPanel.addEventListener('click', onClickControlPanel);
    /** end on click button */

    loadTemplate(response => {
        console.log('loadTemplate: ', response);
        if(response.success) {
            setTimeout(() => {
                loading(false);
            }, 5000);
            iniStripo({html: response.data.html, css: response.data.css}, emailId);
        } 
    });
}

/**
 * Method loadTemplate
 * Get and Load template dari backend 
 * Template default citilink/stripo ataupun template yang sudah pernah dibuat
 * @param {object} callback 
 *              success {boolean}
 *              data {object}
 *                  data.html {string}
 *                  data.css {string}
 */
function loadTemplate(callback) {
    let result = {
        success: false,
        data: {
            html: null,
            css: null
        }
    };

    fetch(`${SITE_URL}get-template`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'Authorization': `Bearer ${accessKey}`
        },
        body: JSON.stringify({
            templateId: templateId,
            emailId: emailId
        })
    })
    .then(response => {
        return response.json();
    })
    .then(data => {
        if(data.success) {
            result.success = true;
            result.data.html = data.html;
            result.data.css = data.css;
            callback(result);
        }
    })
    .catch(error => {
        console.log(error);

        result.message = error;
        callback(result);
    });
}

/**
 * Method getTokenStripo
 * Get Token Stripo
 * @param {object} callback
 *              success {boolean}
 *              token {string}
 */
function getTokenStripo(callback) {
    let result = {
        success: false,
        token: ''
    };

    fetch(`${SITE_URL}get-token-stripo`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'Authorization': `Bearer ${accessKey}`
        }
    })
    .then(response => {
        return response.json();
    })
    .then(data => {
        if(data.token && data.token != '') {
            result.success = true;
            result.token = data.token;
            callback(result);
        }
    })
    .catch(error => {
        console.log(error);

        result.message = error;
        callback(result);
    });
}

/** API Plugin Stripo JS */

    /**
     * Method initStripo
     * @param {object} template
     * @param {string} id
     */
    function iniStripo(template, id) {
        window.Stripo.init({
            settingsId: 'stripoSettingsContainer',
            previewId: 'stripoPreviewContainer',
            codeEditorButtonId: 'codeEditor',
            // undoButtonId: 'undoButton',
            // redoButtonId: 'redoButton',
            html: template.html,
            css: template.css,
            apiRequestData: {
                emailId: id
            },
            // notifications: {
            //     info: notifications.info.bind(notifications),
            //     error: notifications.error.bind(notifications),
            //     warn: notifications.warn.bind(notifications),
            //     loader: notifications.loader.bind(notifications),
            //     hide: notifications.hide.bind(notifications),
            //     success: notifications.success.bind(notifications)
            // },
            // versionHistory: {
            //     changeHistoryLinkId: 'changeHistoryLink',
            //     onInitialized: function(lastChangeIndoText) {
            //         $('#changeHistoryContainer').show();
            //     }
            // },
            getAuthToken: callback => {
                getTokenStripo(response => {
                    console.log('%c Response getTokenStripo: ', 'color: green; font-weight: bold', response);
                    
                    let result = null;
                    if(response.success && response.token) {
                        result = response.token;    
                    }

                    callback(result);
                });
            }
        });
    }

    /**
     * Method getTemplateStripo
     * Get template HTML dan CSS dengan markup editor stripo
     * Method berupa Promise
     * @resolve {object}
     */
    function getTemplateStripo() {
        return new Promise((resolve, reject) => {
            window.StripoApi.getTemplate((HTML, CSS, width, height) => {
                console.log('%c Response getTemplate: ', 'color: blue; font-weight: bold', {
                    HTML: HTML, 
                    CSS: CSS, 
                    width: width, 
                    height: height
                });

                resolve({
                    success: true,
                    data: {
                        html: HTML,
                        css: CSS
                    }
                });
            });
        });
    }

    /**
     * Method compileEmailStripo
     * Get Full HTML
     * Method berupa Promise
     * @param {boolean} minimize
     * @resolve {object} 
     * @reject {object}
     */
    function compileEmailStripo(minimize = true) {
        return new Promise((resolve, reject) => {
            window.StripoApi.compileEmail((error, html, ampHtml, ampErrors) => {
                console.log('%c Response compileEmailStripo: ', 'color: blue; font-weight: bold', {
                    error: error, 
                    html: html, 
                    ampHtml: ampHtml, 
                    ampErrors: ampErrors
                });

                if((!error || error == undefined || error == null) || (!ampErrors || ampErrors == undefined || ampErrors == null) ) {
                    resolve({
                        success: true,
                        data: {
                            html: html,
                            ampHtml: ampHtml, 
                        },
                        error: {
                            html: error,
                            ampHtml: ampErrors 
                        }
                    });
                }
                else {
                    reject({
                        success: false,
                        error: {
                            html: error,
                            ampHtml: ampErrors 
                        }
                    });
                }
            }, minimize);
        });
    }

/** End API Plugin Stripo JS */

/** Event Listener */

    /**
     * Method onClickSave
     */
    async function onClickSave() {
        console.log('%c Button save is clicked...', 'color: blue');
        loading();

        // get html and css editor markup
        let getTemplateEmail = getTemplateStripo().then(response => {
            return {
                html: response.data.html,
                css: response.data.css
            }
        });
        
        // get full html
        let getCompileEmail = compileEmailStripo().then(response => {
            return {
                html: response.data.html
            }
        });

        let stripoData = await Promise.all([getTemplateEmail, getCompileEmail]).then(response => {
            return {
                html: response[0].html,
                css: response[0].css,
                html_css: response[1].html
            };
        });

        fetch(`${SITE_URL}save/${emailId}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'Authorization': `Bearer ${accessKey}`
            },
            body: JSON.stringify({
                templateId: templateId,
                templateName: emailId,
                html: stripoData.html,
                css: stripoData.css,
                htmlFull: stripoData.html_css
            })
        })
        .then(response => {
            return response.json();
        })
        .then(data => {
            loading(false);
            let messageSwal = {
                icon: data.success ? 'success' : 'error',
                title: data.success ? 'Yeah...' : 'Oops...',
                text: data.success ? 'Your template has been saved' : data.message
            };
            if(!data.success) {
                messageSwal.footer = 'Please contact Our Team for information'
            };

            Swal.fire(messageSwal);

            // ganti url ke edit mode
            if(action.toLowerCase() == 'add') {
                let url = new URL(window.location.href);

                url.searchParams.set('action', 'edit');
                url.searchParams.append('emailId', emailId);

                window.history.pushState("","", url.search);
            }
        })
        .catch(error => {
            console.log(error);
    
            Swal.fire({
                icon: 'error',
                title: 'Something went wrong',
                text: error,
                footer: 'Please contact Our Team for information'
            });
        });
    }

    /**
     * Method onClickPreview
     * Memunculkan page preview untuk melihat template versi desktop dan mobile
     */
    function onClickPreview() {
        console.log('%c Button preview is clicked...', 'color: blue');
        
        loading();
        animateCSS('#main-editor', 'fadeOut', () => {
            document.querySelector('#main-editor').style.display = 'none';

            compileEmailStripo()
            .then(response => {
                console.log('%c Response compileEmailStripo: ', 'color: green; font-weight: bold', response);

                document.querySelector('.preview-email').style.display = 'block';

                animateCSS('.preview-email', 'fadeIn', () => {
                    document.querySelector('#frameDekstop').srcdoc = response.data.html;
                    document.querySelector('#frameSmartphone').srcdoc = response.data.html;
                    
                    // hide loading
                    loading(false);
                });
            })
            .catch(error => {
                console.log('%c Error compileEmailStripo: ', 'color: red; font-weight: bold', error);

                loading(false);
                onClickBackPreview();
            })
        });
    }

    /**
     * Method onClickBackPreview
     */
    function onClickBackPreview() {
        console.log('%c Back Button is clicked...', 'color: blue');
        
        loading();
        animateCSS('.preview-email', 'slideOutLeft', () => {
            document.querySelector('.preview-email').style.display = 'none';
            document.querySelector('#main-editor').style.display = 'block';

            document.querySelector('#frameDekstop').srcdoc = '';
            document.querySelector('#frameSmartphone').srcdoc = '';

            // hide loading
            loading(false);
        });
    }

    /**
     * 
     */
    function onClickTestEmail() {
        console.log('%c Back Button is clicked...', 'color: blue');
        $('#myModal').modal();
    }

    /**
     * 
     */
    function onClickControlPanel () {
        console.log('%c Control Panel Button is clicked...', 'color: blue');
        
        let checkActive = false;
        if(controlPanel.classList.contains("active")) {
            checkActive = true;
        }
        else {
            checkActive = false;
        }

        if(checkActive == true) {
            showSettingContainerStripo();
        }
        else {
            hideSettingContainerStripo();
        }
    }


/** End Event Listener */

/**
 * Method animateCSS
 * Memunculkan animasi dari animate.css
 * @param {string} element querySelector
 * @param {string} animation
 * @param {object} callback
 */
function animateCSS(element, animation, callback) {
    let el =  document.querySelector(element);
    el.classList.add('animated', animation);

    function handleAnimationEnd() {
        el.classList.remove('animated', animation);
        el.removeEventListener('animationend', handleAnimationEnd);

        if (typeof callback === 'function') callback();
    }

    el.addEventListener('animationend', handleAnimationEnd);
}

/**
 * Method loading
 * Show loading
 * @param {boolean} show default true
 */
function loading(show = true) {
    let content = document.getElementById('main-editor');
    let loading = document.getElementById('loader-wrapper');
    if(show) {
        content.classList.remove("show-loading");
        content.classList.add("show-loading");

        loading.style.display = "block";
    }
    else {
        content.classList.remove("show-loading");
        loading.style.display = "none";
    }
}

function hideSettingContainerStripo() {
    controlPanel.classList.add("active");
    
    document.querySelector('#stripoPreviewContainer').parentElement.removeAttribute('class');
    document.querySelector('#stripoSettingsContainer').parentElement.style.display = 'none';
}

function showSettingContainerStripo() {
    controlPanel.classList.remove("active");
    
    document.querySelector('#stripoSettingsContainer').parentElement.style.display = 'block';
    document.querySelector('#stripoPreviewContainer').parentElement.setAttribute("class", "col-lg-9 col-md-9 col-sm-6 col-xs-12");
}