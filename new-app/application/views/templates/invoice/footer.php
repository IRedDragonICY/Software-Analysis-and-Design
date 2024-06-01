<script>
    function copyToClipboard() {
        console.time('time2');
        var temp = document.createElement('input');
        var texttoCopy = document.getElementById('kodebayar').value;
        var buttontemp = document.getElementById('salinkodebayar').innerHTML;
        temp.type = 'input';
        temp.setAttribute('value', texttoCopy);
        document.body.appendChild(temp);
        temp.select();
        document.execCommand("copy");
        temp.remove();
        document.getElementById('salinkodebayar').innerHTML = 'Berhasil disalin!';
        document.getElementById("salinkodebayar").disabled = true;
        setTimeout(function() {
            document.getElementById('salinkodebayar').innerHTML = buttontemp;
        }, 3000);
        document.getElementById("salinkodebayar").disabled = false;
        console.timeEnd('time2');
    }

    function openModal() {
        document.getElementById("backdrop").style.display = "block";
        document.getElementById("exampleModal").style.display = "block";
        document.getElementById("exampleModal").classList.add("show");
        document.getElementById("instructionstitle").click();
    }

    function closeModal() {
        document.getElementById("backdrop").style.display = "none";
        document.getElementById("exampleModal").style.display = "none";
        document.getElementById("exampleModal").classList.remove("show");
    }

    function zoomQR() {
        document.getElementById("backdrop").style.display = "block";
        document.getElementById("zoomModal").style.display = "block";
        document.getElementById("zoomModal").classList.add("show");
    }

    function closeQR() {
        document.getElementById("backdrop").style.display = "none";
        document.getElementById("zoomModal").style.display = "none";
        document.getElementById("zoomModal").classList.remove("show");
    }

    function returnToMerchant() {
        window.open('<?= base_url() ?>invoice', '_self');
    }

    // accordion
    const accordions = document.querySelectorAll('.accordion');
    const contents = document.querySelectorAll('.accordion-content');
    const arrows = document.querySelectorAll('.arrow');
    const active = (item, index) => {
        contents.forEach((content, i) => {
            if (i !== index) {
                content.style.height = 0;
            }
        })
        item.style.height = `${item.scrollHeight}px`;
        arrows.forEach((arrow, i) => {
            arrow.style.transform = 'rotate(45deg)';
            if (i !== index) {
                arrow.style.transform = 'rotate(-135deg)';
            }

        })
    }
    accordions.forEach(
        (accordion, i) => {
            accordion.addEventListener("click", () => active(contents[i], i))
        });
</script>
</body>

</html>