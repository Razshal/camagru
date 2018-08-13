<?php ob_start(); ?>
<form class="loginForm" method="post" enctype="multipart/form-data">
    <div>
        Take a picture<br/>
        <video autoplay="true" id="camera"></video>
    </div>
    Or
    <div>
        Send from your computer<br/>
        <input type="file" name="fileToUpload" id="fileToUpload"/>
    </div>
    <input type="text" name="title" placeholder="Post title"/>
    <textarea placeholder="Post description" name="text"></textarea>
</form>
<script>
    navigator.mediaDevices.getUserMedia(
        {
            audio: false,
            video: true //{
                //width: { ideal: 1280 }, height: { ideal: 720 }
            //}
        }).then((mediaStream) => {
            let cameraPlace = document.getElementById('camera');
            cameraPlace.srcObject = mediaStream;
            cameraPlace.onloadedmetadata = () => {
                cameraPlace.play();
            }
    }).catch((error) => {
        if (error) {
            let errorPlace = document.getElementById('errorPlace');
            errorPlace.style.display = 'block';
            errorPlace.innerHTML = error;
        }
    })
</script>
<?php $content = ob_get_clean(); ?>
