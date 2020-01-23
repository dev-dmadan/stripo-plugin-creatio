const accessKey = document.getElementById('access_key').value;
const action = document.getElementById('action').value;
const templateId = document.getElementById('templateId').value;
const emailId = document.getElementById('emailId').value;
const save = document.getElementById('save');
const saveAsTemplate = document.getElementById('saveAsTemplate');
const preview = document.getElementById('preview');
const backPreview = document.getElementById('back-preview');

loading();
window.onload = () => {
    console.log('%c Document ready...', 'color: green; font-weight: bold');
    
    loading(false);
    $('[data-toggle="tooltip"]').tooltip();

    /** on click button */
        save.addEventListener('click', onClickSave);
        preview.addEventListener('click', onClickPreview);
        saveAsTemplate.addEventListener('click', onClickSaveAsTemplate);
        backPreview.addEventListener('click', onClickBackPreview);
    /** end on click button */

    loadTemplate(response => {
        console.log('loadTemplate: ', response);
        if(response.success) {
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
            html: template.html,
            css: template.css,
            apiRequestData: {
            emailId: id
            },
            getAuthToken: function(callback) {
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
     * Method compileEmailStripo
     * @param {object} callback
     * @param {boolean} minimize
     */
    function compileEmailStripo(callback, minimize = true) {
        window.StripoApi.compileEmail((error, html, ampHtml, ampErrors) => {
            callback({
                error: error, 
                html: html, 
                ampHtml: ampHtml, 
                ampErrors: ampErrors
            });

            console.log({
                error: error, 
                html: html, 
                ampHtml: ampHtml, 
                ampErrors: ampErrors
            });
        }, minimize);
    }

/** End API Plugin Stripo JS */

/** Event Listener */

    /**
     * Method onClickSave
     */
    function onClickSave() {
        console.log('%c Button save is clicked...', 'color: blue');
    }

    /**
     * Method onClickSaveAsTemplate
     */
    function onClickSaveAsTemplate() {
        console.log('%c Button save as template is clicked...', 'color: blue');
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

            // get full html+css
            compileEmailStripo((response) => {
                document.querySelector('.preview-email').style.display = 'block';

                animateCSS('.preview-email', 'fadeIn', () => {
                    document.querySelector('#frameDekstop').srcdoc = response.html;
                    document.querySelector('#frameSmartphone').srcdoc = response.html;
                    
                    // hide loading
                    loading(false);
                });
            });
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