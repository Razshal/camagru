<?php ob_start(); ?>
<script>
    window.onload = async () => {
        const captureButton = document.getElementById('captureButton');
        const canvas = document.getElementById('canvas');
        const video = document.getElementById('video');

        /************** Camera Stream **************/

        if (navigator.mediaDevices === undefined)
            navigator.mediaDevices = {};
        if (navigator.mediaDevices.getUserMedia === undefined) {
            navigator.mediaDevices.getUserMedia = constraints => {
                let getUserMedia = navigator.webkitGetUserMedia || navigator.mozGetUserMedia;
                if (!getUserMedia)
                    return Promise.reject(new Error('Cannot use camera with your browser'));
                return new Promise(function(resolve, reject) {
                    getUserMedia.call(navigator, constraints, resolve, reject);
                });
            }
        }
        navigator.mediaDevices.getUserMedia({ audio: false, video: true })
            .then(function(stream) {
                if ("srcObject" in video)
                    video.srcObject = stream;
                else
                    video.src = window.URL.createObjectURL(stream);
                video.onloadedmetadata = video.play();
            })
            .catch(function(error) {
                let errorPlace = document.getElementById("errorPlace");
                errorPlace.style.display = "block";
                video.style.display = "none";
                errorPlace.innerHTML = error.name + ": " + error.message;
                errorPlace.classList.add("error");
            });

        /************** Camera Caption **************/

            captureButton.onclick = () => {
                canvas.style.display = 'block';
                canvas.getContext('2d').drawImage(video, 0, 0);
            }
        }
</script>

<section id="cameraArea" class="container">
    <video autoplay id="video" width="400" height="400"></video>
    <button id="captureButton">Snap</button>
</section>

<form class="loginForm" method="post" enctype="multipart/form-data">
    <canvas id="canvas" width="400" height="400" style="display: none;"></canvas>
    Or
    <div>
        Send from your computer<br/>
        <input type="file" name="fileToUpload" id="fileToUpload"/>
    </div>
    <input type="text" name="title" placeholder="Post title"/>
    <textarea placeholder="Post description" name="text"></textarea>
</form>

<?php $content = ob_get_clean(); ?>
