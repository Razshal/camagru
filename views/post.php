<?php ob_start(); ?>
<script>
    if (navigator.mediaDevices === undefined)
        navigator.mediaDevices = {};
    if (navigator.mediaDevices.getUserMedia === undefined) {
        navigator.mediaDevices.getUserMedia = constraints => {
            let getUserMedia = navigator.webkitGetUserMedia || navigator.mozGetUserMedia;
            if (!getUserMedia)
                return Promise.reject(new Error('getUserMedia is not implemented in this browser'));
            return new Promise(function(resolve, reject) {
                getUserMedia.call(navigator, constraints, resolve, reject);
            });
        }
    }
    navigator.mediaDevices.getUserMedia({ audio: false, video: true })
        .then(function(stream) {
            let video = document.getElementById("video");
            if ("srcObject" in video)
                video.srcObject = stream;
            else
                video.src = window.URL.createObjectURL(stream);
            video.onloadedmetadata = () => {
                video.play();
            };
        })
        .catch(function(error) {
            let errorPlace = document.getElementById("errorPlace");
            let video = document.getElementById("video");
            errorPlace.style.display = "block";
            video.style.display = "none";
            errorPlace.innerHTML = error.name + ": " + error.message;
        });
</script>
<video autoplay id="video" width="400" height="400"></video>
<form class="loginForm" method="post" enctype="multipart/form-data">
    <canvas id="capture"></canvas>
    Or
    <div>
        Send from your computer<br/>
        <input type="file" name="fileToUpload" id="fileToUpload"/>
    </div>
    <input type="text" name="title" placeholder="Post title"/>
    <textarea placeholder="Post description" name="text"></textarea>
</form>


<?php $content = ob_get_clean(); ?>
