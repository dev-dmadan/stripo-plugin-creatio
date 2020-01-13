const save = document.getElementById('save');
const saveAsTemplate = document.getElementById('saveAsTemplate');
const preview = document.getElementById('preview');

loading();

window.onload = () => {
    console.log('%c Document ready...', 'color: green; font-weight: bold');
    
    loading(false);
    $('[data-toggle="tooltip"]').tooltip();

    /** on click button */
        save.addEventListener('click', onClickSave);
        preview.addEventListener('click', onClickPreview);
        saveAsTemplate.addEventListener('click', onClickSaveAsTemplate);
    /** end on click button */

    fetch('https://plugins.stripo.email/api/v1/auth', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            pluginId: 'c570a38a2dec4fef80c9d6c5d8aea09b',
            secretKey: 'd83328ff24e54477a019bb3c6f6b9df8'
        })
    })
    .then(response => {
        return response.json();
    })
    .then(data => {
        console.log(data);
    })
    .catch(error => {
        console.log(error);
    });
}

/**
 * 
 */
function iniStripo(template, emailId) {
    window.Stripo.init({
        settingsId: 'stripoSettingsContainer',
        previewId: 'stripoPreviewContainer',
        html: template.html,
        css: template.css,
        apiRequestData: {
           emailId: emailId
        },
        getAuthToken: function(callback) {
            console.log('%c Response getAuthToken ');
        }
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