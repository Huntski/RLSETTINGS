let main = document.querySelector('main');
let loading = document.querySelector('.loading');
let current_main = main.innerHTML;
let url = window.location;
// let baseurl = url.protocol + "//" + url.host + '/';
let baseurl = url.protocol + "//" + url.host + '/RLSETTINGS/public/';
let title = document.querySelector('title');
let current_title = title.innerHTML;
// ----------------------------------------------------------------------------

function request(request) { // Request for template with ajax request
    if (request == current_page) return;
    current_page = request;
    title.innerHTML = current_title + ' - ' + request.toUpperCase();
    let request_url = baseurl + 'template/' + request;
    loading.style.display = 'block';
    console.log(request_url);
    $.ajax({
        datatype: 'html',
        url: request_url
    }).done(function(response) {
        window.history.pushState("String", "Title", baseurl+request);
        fadeTransition (response);
    }).fail(function() {
        loading.style.display = 'none';
        console.error("Ajax Request Failed");
    });
}

// ----------------------------------------------------------------------------

function fadeTransition (html) { // Show new main page (Fade new page in)
    main.classList.remove('fadeIn');
    main.classList.add('fadeOut');
    setTimeout(function() {
        loading.style.display = 'none';
        main.innerHTML = html;
        main.classList.remove('fadeOut');
        main.classList.add('fadeIn');

        includeJavascript();
    }, 500);
}

// ----------------------------------------------------------------------------

function includeJavascript() {
    // Home search page
    try {
        let search_player = document.querySelector('.search_player');
        let search_results = document.querySelector('.search_results');

        // ----------------------------------------------------------------

        function search (query) {
            let request_url = baseurl + 'search/' + query;
            let result, html = '';
            $.ajax({
                datatype: 'json',
                url: request_url
            }).done(function(json) {
                if (!json) {
                    search_results.innerHTML = '';
                } else {
                    if (json == 'nothing') {
                        html += `<h2 class='fadeIn' style='margin-top: 30px;'>No player found.</h2>`
                    } else {
                        result = JSON.parse(json);
                        result.forEach(function(e) {
                            // <img src="`+baseurl+`img/pro.png" alt="">
                            html += `

                                <div class="result" id="`+e.global_id+`">
                                    <div class="profile">
                                        <img src="public/img/avatars/`+e.avatar+`" alt=" ">
                                    </div>
                                    <h2>`+e.usern+`</h2>
                                </div>

                            `;
                        });
                    }

                    search_results.innerHTML = html;

                    let results = document.querySelectorAll('.result');
                    for (let i = 0; i < results.length; i++) {
                        results[i].addEventListener('click', () => {
                            request('inspect/'+results[i].id);
                        })
                    }
                }
            }).fail(function() {
                console.error("Ajax search failed.");
            });
        }

        // ----------------------------------------------------------------

        search_player.addEventListener('keyup', (e) => {
            if (e.key == 'Enter') {
                search(search_player.value);
            }
        });

    } catch (e) {
        // console.log(e);
    }

    // Profile page
    try {
        // Check for avatar submit
        let avatar_form = document.querySelector('.avatar_form');
        let avatar_file = document.querySelector('.avatar_file');
        let avatar_label = document.querySelector('.avatar_label');

        avatar_label.addEventListener('click', () => {
            let i = setInterval (function() {
                if (avatar_file.value != "") {
                    avatar_form.submit();
                }
                console.log('uploading');
            }, 1000);
        });
    } catch (e) {
        console.log(e);
    }

    try {
        // Update range value
        let checkbox = document.querySelector('#edit');
        let checkbox_label = document.querySelector('.checkbox_label');
        let camera_form = document.querySelector('.inspect_form');
        let camera_form_edit = document.querySelector('.edit_form');

        checkbox_label.addEventListener('click' , () => {
            if (!checkbox.checked) {
                camera_form.style.display = 'none';
                camera_form_edit.style.display = 'block';
                return;
            }
            camera_form.style.display = 'block';
            camera_form_edit.style.display = 'none';
        });

        // ------------------------------------------------------------------

        let ranges = ['f', 'd', 'h', 'a', 's', 'ss', 'ts'];
        let outputs = [];

        for (let i = 0; i < ranges.length; i++) outputs.push(ranges[i] + '_output');

        for (let i = 0; i < ranges.length; i++) {
            ranges[i] = document.querySelector('.'+ranges[i]+'_range');
            ['change', 'input'].forEach(function(e) {
                ranges[i].addEventListener(e, () => {
                    let output = document.querySelector('.'+outputs[i]);
                    output.innerHTML = parseFloat(Math.round(ranges[i].value * 100) / 100).toFixed(2);
                })
            });
            document.querySelector('.'+outputs[i]).innerHTML = parseFloat(Math.round(ranges[i].value * 100) / 100).toFixed(2);
        }
    } catch (e) {
        // console.log(e);
    }
}

// ----------------------------------------------------------------------------

includeJavascript();