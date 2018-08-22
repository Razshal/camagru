function userLog(type, message)
{
    let errorPlace = document.getElementById("errorPlace");
    let errorElem = document.createElement('p');

    errorPlace.style.display = "block";
    errorElem.innerHTML = message.toString();
    errorElem.classList.add(type);
    errorElem.onclick = () =>
        errorElem.parentNode.removeChild(errorElem);
    errorPlace.appendChild(errorElem);
}

function newPostPreview(image)
{
    let img = document.createElement('img');
    let previewArea = document.getElementById('previousPosts');

    img.classList.add('previewElem');
    img.src = image;
    img.id = image;
    img.onclick = () =>
    {
        if (confirm("Would you like to delete this post ?"))
        {
            let formData = new FormData();

            console.log(this);
            formData.append('image', image);
            fetch('index.php?action=deletePost', {
                method: 'POST',
                body: formData,
                credentials: 'include'
            }).then(response =>
            {
                if (response.status === 200)
                {
                    userLog('success', 'Your image has been deleted');
                    previewArea.childNodes.forEach(post =>
                    {
                        if (post.src === image)
                            post.parentNode.removeChild(post);
                    });
                }
                else
                    userLog('error', 'Error deleting your image, please retry later');
            });
        }
    };
    previewArea.appendChild(img);
}

window.onload = async () =>
{
    let cameraAccess = false;
    let fileToSend;
    const previewWidth = document.body.clientWidth - 50;
    const sendButton = document.getElementById('sendButton');
    const captureButton = document.getElementById('captureButton');
    const clearButton = document.getElementById('clearButton');
    const video = document.getElementById('video');
    const userFile = document.getElementById("userFile");
    const cameraPlace = document.getElementById('cameraPlace');
    const canvas = document.getElementById('canvas');
    const filtersBar = document.getElementById('filtersBar');
    const previousPosts = document.getElementById('previousPosts');
    const filters = [];
    const cameraConstraints =
        {
            audio: false,
            video: {
                width: 1280,
                height: 720,
                facingMode: 'user'
            }
        };

    /************** Clear all setup button **************/

    clearButton.onclick = () =>
    {
        let actualFilters = document.getElementsByClassName('filter');
        let imageObjects = document.getElementsByClassName('obj');

        captureButton.disabled = true;
        while (actualFilters[0])
            actualFilters[0].parentNode.removeChild(actualFilters[0]);
        while (imageObjects[0])
            imageObjects[0].parentNode.removeChild(imageObjects[0]);

        captureButton.style.display = 'inline-block';
        canvas.style.display = 'none';
        video.style.display = 'block';
    };

    /************** Camera button **************/

    captureButton.onclick = () =>
    {
        canvas.style.display = 'block';
        canvas.width = video.width;
        canvas.height = video.height;
        video.style.display = 'none';
        canvas.getContext('2d').drawImage(video, 0, 0, video.width, video.height);
        fileToSend = canvas.toDataURL();
    };

    /************** Camera preview dynamic size **************/

    if (document.body.clientWidth <= 1024)
    {
        cameraPlace.width = previewWidth;
        video.width = previewWidth;
    }
    else
        video.width = previewWidth;
    video.height = video.width / 16 * 9;
    cameraPlace.height = cameraPlace.width / 16 * 9;

    /************** Camera Stream **************/

    if (navigator.mediaDevices === undefined)
        navigator.mediaDevices = {};
    if (navigator.mediaDevices.getUserMedia === undefined)
    {
        navigator.mediaDevices.getUserMedia = constraints =>
        {
            let getUserMedia = navigator.webkitGetUserMedia
                || navigator.mozGetUserMedia;
            if (!getUserMedia)
                userLog('error', 'Cannot use camera with your browser');
            else
            {
                return new Promise((resolve, reject) =>
                    getUserMedia.call(navigator, constraints, resolve, reject));
            }
        }
    }
    navigator.mediaDevices.getUserMedia(cameraConstraints)
        .then(function(stream)
        {
            cameraAccess = true;
            if ("srcObject" in video)
                video.srcObject = stream;
            else
                video.src = window.URL.createObjectURL(stream);
            video.onloadedmetadata = video.play();
        }).catch(function(error)
        {
            cameraAccess = false;
            captureButton.disabled = true;
            if (error.name === "NotAllowedError")
                userLog('error', "Camera access not allowed");
            else
                userLog('error', error.name + ": " + error.message);
        });

    /************** Filters **************/

    filters[0] = "/views/camera/filters/Batman.png";
    filters[1] = "/views/camera/filters/Anon.png";
    filters[2] = "/views/camera/filters/Carnival.png";

    filters.forEach((elem) =>
    {
        let filterPreview = new Image();

        filterPreview.src = elem;
        filterPreview.classList.add('filterPreview');
        filterPreview.onclick = (event) =>
        {
            let filter = new Image();
            let actualFilters = document.getElementsByClassName('filter');

            if (canvas.style.display === 'block') //Avoid filter preview bug
                clearButton.onclick();
            canvas.style.display = 'none';
            while (actualFilters[0])
                actualFilters[0].parentNode.removeChild(actualFilters[0]);
            captureButton.disabled = !cameraAccess;
            filter.src = event.target.src;
            filter.classList.add('filter');
            filter.width = video.width;
            filter.height = video.height;
            cameraPlace.appendChild(filter);
        };
        filtersBar.appendChild(filterPreview);
    });

    /************** User upload preview **************/

    userFile.onchange = () =>
    {
        let file = userFile.files[0];
        let imageType = /^image\//;
        let userImage = document.createElement('img');
        let reader;

        clearButton.onclick();
        captureButton.disabled = true;
        captureButton.style.display = 'none';
        if (!window.FileReader)
            userLog('error', 'Cannot preview file with your browser');
        if (!imageType.test(file.type))
        {
            userLog('error', 'Not an image file, ' +
                'refresh the page and try with another file');
            return;
        }
        userImage.classList.add('obj');
        userImage.file = file;
        userImage.width = video.width;
        userImage.height = video.height;
        video.style.display = 'none';
        cameraPlace.appendChild(userImage);
        reader = new FileReader();
        reader.onload = (event) => {
            fileToSend = event.target.result;
            userImage.src = event.target.result;
        };
        reader.readAsDataURL(file);
    };

    /************** Send **************/

    sendButton.onclick = () =>
    {
        //Preparing form with text and user pictures
        let formData = new FormData();

        if (!fileToSend || !document.getElementsByClassName('filter')[0])
        {
            userLog('error', 'You must capture an image ' +
                'or choose one from your computer and add a filter');
            return;
        }
        formData.enctype = 'multipart/form-data';
        formData.append('desc',
            document.getElementById('desc').value);
        formData.append('filter',
            document.getElementsByClassName('filter')[0].src);
        formData.append('image', fileToSend);
        //Sending form to the server
        fetch('index.php?action=post', {
            method: 'POST',
            body: formData,
            credentials: 'include'
        }).then(response =>
        {
            if (response.status === 201)
                userLog('success', 'Your image has been posted');
            else
                userLog('error', 'Error treating your image, please retry later');
        });
    };

    /************** Preview posts **************/

    fetch('http://localhost:8080/index.php?action=getUserPosts&user=mfonteni', {
        credentials: 'include'
    })
        .then(response => response.json())
        .then(posts =>
            {
                let i = 0;
                while (posts[i])
                    newPostPreview(posts[i++].image);
            })
        .catch(err => userLog('error', err));
};