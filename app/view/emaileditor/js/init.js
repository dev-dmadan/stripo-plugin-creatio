const accessKey = document.getElementById('access_key').value;
const action = document.getElementById('action').value;
const templateId = document.getElementById('templateId').value;
const save = document.getElementById('save');
const saveAsTemplate = document.getElementById('saveAsTemplate');
const preview = document.getElementById('preview');
const backPreview = document.getElementById('back-preview');

let emailId = document.getElementById('emailId').value;

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

    // fetch('https://plugins.stripo.email/api/v1/auth', {
    //     method: 'POST',
    //     headers: {
    //         'Content-Type': 'application/json',
    //         'Accept': 'application/json'
    //     },
    //     body: JSON.stringify({
    //         pluginId: 'c570a38a2dec4fef80c9d6c5d8aea09b',
    //         secretKey: 'd83328ff24e54477a019bb3c6f6b9df8'
    //     })
    // })
    // .then(response => {
    //     return response.json();
    // })
    // .then(data => {
    //     console.log(data);
    // })
    // .catch(error => {
    //     console.log(error);
    // });

    // console.log(accessKey, BASE_URL, SITE_URL);

    loadDefaultTemplate()
    .then(template => {
        console.log(template);

        iniStripo(template, '123');
    });
}

/**
 * 
 */
function init() {
    if(action.toLowerCase() == 'add') {
        add();
    }
    else if(action.toLowerCase() == 'edit') {
        edit();
    }
    else {
        // tampilkan pesan error
    }
}

/**
 * 
 */
function add() {

}

/**
 * 
 */
function iniStripo(template, id) {
    window.Stripo.init({
        settingsId: 'stripoSettingsContainer',
        previewId: 'stripoPreviewContainer',
        html: template.html,
        css: template.css,
        apiRequestData: {
           emailId: emailId
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
 * 
 */
async function getTokenStripo(callback) {
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

/**
 * 
 */
async function loadTemplate() {
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
 * 
 */
async function loadDefaultTemplate() {
    let result = {
        html: null,
        css: null
    };
    const html = fetch('https://raw.githubusercontent.com/ardas/stripo-plugin/master/Public-Templates/Basic-Templates/Trigger%20newsletter%20mockup/Trigger%20newsletter%20mockup.html')
                .then(response => {
                    return response.text();
                });

    const css = fetch('https://raw.githubusercontent.com/ardas/stripo-plugin/master/Public-Templates/Basic-Templates/Trigger%20newsletter%20mockup/Trigger%20newsletter%20mockup.css')
                .then(response => {
                    return response.text();
                });
    
    return await Promise.all([html, css])
    .then(response => {
        result.html = response[0];
        result.css = response[1];

        return result;
    });
}

/**
 * 
 */
async function getAuthToken() {
    let url = 'https://plugins.stripo.email/api/v1/auth';
    const request = await fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            pluginId: '',
            secretKey: ''
        })
    })
    .then(response => {
        return response.json();
    })
    .then(data => {
        
    })
    .catch(error => {

    });

    return await request.json();
}

/**
 * 
 */
function onClickSave() {
    console.log('%c Button save is clicked...', 'color: blue');


}

/**
 * 
 */
function onClickSaveAsTemplate() {
    console.log('%c Button save as template is clicked...', 'color: blue');

}

/**
 * 
 */
function onClickPreview() {
    console.log('%c Button preview is clicked...', 'color: blue');
    loading();

    animateCSS('#main-editor', 'fadeOut', function() {
        document.querySelector('#main-editor').style.display = 'none';
        document.querySelector('.preview-email').style.display = 'block';
        animateCSS('.preview-email', 'fadeIn', function() {
            // hide loading
            loading(false);
        });
    });

    // let mainEditor =  document.querySelector('#main-editor');
    // let previewEmail =  document.querySelector('.preview-email');
    // mainEditor.classList.add('animated', 'fadeOut');

    // mainEditor.addEventListener('animationend', function() { 
    //     // hide email editor
    //     mainEditor.style.display = 'none';
    //     // hapus si animasi
    //     mainEditor.classList.remove('animated', 'fadeOut');

    //     // // preview email
    //     previewEmail.style.display = 'block';
    //     previewEmail.classList.add('animated', 'fadeIn');
    //     previewEmail.addEventListener('animationend', function() {
    //         // hapus si animasi
    //         previewEmail.classList.remove('animated', 'fadeIn');
    //     });
    // });
}

/**
 * 
 */
function onClickBackPreview() {
    console.log('%c Back Button is clicked...', 'color: blue');
    loading();

    animateCSS('.preview-email', 'slideOutLeft', function() {
        document.querySelector('.preview-email').style.display = 'none';
        document.querySelector('#main-editor').style.display = 'block';
        // hide loading
        loading(false);
    });
}

/**
 * 
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
 * 
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

/**
 * 
 */