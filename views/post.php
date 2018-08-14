<?php ob_start(); ?>

<script src="views/camera/postPageScript.js"></script>
<div id="cameraPlace">
    <video autoplay id="video" width="640" height="360"></video>
    <canvas id="canvas" style="display: none"></canvas>
</div>
<button id="captureButton">Snap</button>
Or send from your computer<br/>
<input type="file" accept="image/*" name="userFile" id="userFile"/>
<input type="text" name="title" placeholder="Post title"/>
<textarea placeholder="Post description" name="text"></textarea>

<?php $content = ob_get_clean(); ?>
