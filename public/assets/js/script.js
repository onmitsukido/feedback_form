document.addEventListener('DOMContentLoaded', function() {
    if (document.querySelector('body h2') && document.querySelector('body h2').textContent.includes('Спасибо')) {
        setTimeout(function() {
            var smiley = document.createElement("div");
            smiley.textContent = ":)";
            smiley.style.textAlign = "center";
            smiley.style.fontSize = "24px";
            smiley.style.marginTop = "20px";
            smiley.style.color = "#555";
            document.body.appendChild(smiley);
        }, 5000);
    }
});