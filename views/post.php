<?php ob_start(); ?>
<script src="views/camera/postPageScript.js"></script>
<link rel="stylesheet" type="text/css" href="/views/style/postPage.css">
<div id="cameraPlace">
    <video autoplay id="video"></video>
</div>
<div id="buttons">
    <button id="captureButton">Snap</button>
    <button id="clearButton">Clear</button>
</div>
<div id="filtersBar">

</div>
<div id="preview">
    <canvas id="canvas"></canvas>
</div>
Or send from your computer<br/>
<input type="file" accept="image/*" name="userFile" id="userFile"/>
<input type="text" name="title" placeholder="Post title"/>
<textarea placeholder="Post description" name="text"></textarea>
<button id="sendButton">Send</button>

<?php $content = ob_get_clean(); ?>
