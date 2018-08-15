function userError(message)
{
    let errorPlace = document.getElementById("errorPlace");
    let errorElem = document.createElement('p');

    errorPlace.style.display = "block";
    errorElem.innerHTML = message.toString();
    errorElem.classList.add('error');
    errorPlace.appendChild(errorElem);
}

window.onload = async () =>
{
    const sendButton = document.getElementById('sendButton');
    const captureButton = document.getElementById('captureButton');
    const clearButton = document.getElementById('clearButton');
    const video = document.getElementById('video');
    const userFile = document.getElementById("userFile");
    const cameraPlace = document.getElementById('cameraPlace');
    const canvas = document.getElementById('canvas');
    const filtersBar = document.getElementById('filtersBar');
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
        while (actualFilters[0])
            actualFilters[0].parentNode.removeChild(actualFilters[0]);
        while (imageObjects[0])
            imageObjects[0].parentNode.removeChild(imageObjects[0]);

        captureButton.style.display = 'inline-block';
        canvas.style.display = 'none';
        video.style.display = 'block';
    };

    /************** Camera preview dynamic size **************/

    if (document.body.clientWidth <= 1024)
    {
        cameraPlace.width = document.body.clientWidth;
        video.width = document.body.clientWidth;
    }
    else
        video.width = 1024;
    video.height = video.width / 16 * 9;
    cameraPlace.height = cameraPlace.width / 16 * 9;

    /************** Camera Stream **************/

    if (navigator.mediaDevices === undefined)
        navigator.mediaDevices = {};
    if (navigator.mediaDevices.getUserMedia === undefined)
    {
        navigator.mediaDevices.getUserMedia = constraints =>
        {
            let getUserMedia = navigator.webkitGetUserMedia || navigator.mozGetUserMedia;
            if (!getUserMedia)
            {
                let message = 'Cannot use camera with your browser';
                userError(message);
            }
            else
            {
                return new Promise(function (resolve, reject) {
                    getUserMedia.call(navigator, constraints, resolve, reject);
                });
            }
        }
    }
    navigator.mediaDevices.getUserMedia(cameraConstraints)
        .then(function(stream)
        {
            if ("srcObject" in video)
                video.srcObject = stream;
            else
                video.src = window.URL.createObjectURL(stream);
            video.onloadedmetadata = video.play();
        })
        .catch(function(error)
        {
            if (error.name === "NotAllowedError")
                userError("Camera access not allowed");
            else
                userError(error.name + ": " + error.message);
        });

    /************** Camera Caption **************/

    // if (!document.getElementsByClassName('filter')[0])


    captureButton.onclick = () =>
    {
        canvas.style.display = 'block';
        canvas.width = video.width;
        canvas.height = video.height;
        canvas.getContext('2d').drawImage(video, 0, 0, video.width, video.height);
        document.getElementById('preview')
            .appendChild(document.getElementsByClassName('filter')[0]);
    };

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
            filter.src = event.target.src;
            filter.classList.add('filter');
            filter.width = video.width;
            filter.height = video.height;
            while (actualFilters[0])
                actualFilters[0].parentNode.removeChild(actualFilters[0]);
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
        captureButton.style.display = 'none';
        if (!window.FileReader)
            userError('Cannot preview file with your browser');
        if (!imageType.test(file.type))
        {
            userError('Not an image file,' +
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
        reader.onload = (event) => userImage.src = event.target.result;
        reader.readAsDataURL(file);
    };

    /************** Send **************/

    // sendButton.onclick = () =>
    // {
    //     if (!userFile.files[0] && !canvas.style.display === )
    //     const req = new XMLHttpRequest();
    //     req.open('GET')
    // }


};