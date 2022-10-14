<?php
include("header.php");
?>

<h3 class="display-4 d-flex justify-content-center p-5 m-5">Shorten URLs</h3>

<form class="mt-5 d-flex justify-content-center align-items-center">
    <div class="container">
        
        <div class="container pl-4 pr-4">
            <label for="URLinput" class="form-label">URL</label>
            <input type="text" class="form-control" id="URLinput">
            <div id="emailHelp" class="form-text">Enter the URL you wanted to shorten</div>
            <div class="container d-flex justify-content-center align-items-center">
                <button id="btn" type="button" class="btn btn-xl btn-outline-secondary mt-3">Shorten</button>
            </div>
        </div>
        <div class="container mt-5 d-flex justify-content-center align-items-center">
            <input id="urlDisplay" class="form-control" type="text" value="Shortened URL will appear here" aria-label="Disabled input example" disabled readonly>
            <button id="copyBtn" type="button" class="btn btn-dark">C</button>
        </div>
        <div id="lds-ring" class="d-flex justify-content-center align-items-center"><div></div><div></div><div></div>

    </div>
    <div id="snackbar">Copied</div>
</form>

<script>
    var btn = document.getElementById("btn");
    var copyBtn = document.getElementById("copyBtn");
    var urlTextBox = document.getElementById("URLinput");
    var urlDisplayBox = document.getElementById("urlDisplay");
    var loader = document.getElementById("lds-ring");

    btn.onclick = () => {

        loader.className = "show";
        const callUrlShortener = async () => {

            if (!valid(urlTextBox.value)) {
                alert("Invalid website");
                return;
            }

            console.log("clicked");
            const req = await fetch('https://api-ssl.bitly.com/v4/shorten', {
                method: 'POST',
                headers: {
                    'Authorization': 'Bearer 7593b4d8c3a48e6bb4bc5e33dda42b0606a0af1b',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    "long_url": urlTextBox.value,
                    "domain": "bit.ly"
                })
            });

            const json = req.json();
            return json;

        }

        callUrlShortener().then(data => {
            loader.className = loader.className.replace("show", ""); 
            urlDisplayBox.value = data.id;
        });
    }

    copyBtn.onclick = () => {

        urlDisplayBox.select();
        urlDisplayBox.setSelectionRange(0, 99999);
        navigator.clipboard.writeText(urlDisplayBox.value);
        
        var x = document.getElementById("snackbar");
        x.className = "show";
        setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);

    }

    const valid = () => {

        const pattern = /http[s]{0,1}\:\/\/.+\.[a-zA-Z]{2,4}/gi;
        return urlTextBox.value.match(pattern);
    }
</script>
</body>

</html>