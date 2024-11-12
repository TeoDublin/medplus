

<div class="p-2 card card-body w-35 mt-2">
    <input type="text" id="id" name="id" value="<?php echo $params['id']??'';?>" hidden/>
    <div class="d-flex flex-row">
        <div class="mb-1 w-100">
            <input type="text" class="form-control" id="nominativo" name="nominativo" value="Daniela Zanotti"/>
        </div>
    </div>
    <div class="d-flex flex-row">
        <div class="mb-1 w-100">
            <input type="text" class="form-control" id="nominativo" name="nominativo" value="Dr. in Fisioterapia"/>
        </div>
    </div>
    <div class="d-flex flex-row">
        <div class="mb-1 w-100">
            <input type="text" class="form-control" id="nominativo" name="nominativo" value="Specialista in Terapia Manuale"/>
        </div>
    </div>
    <div class="d-flex flex-row">
        <div class="mb-1 w-100">
            <input type="text" class="form-control" id="nominativo" name="nominativo" value="Fisioterapista ISICO NAPOLI"/>
        </div>
    </div>
    <div class="d-flex flex-row">
        <div class="mb-1 w-100">
            <input type="text" class="form-control" id="nominativo" name="nominativo" value="Iscrizione Albo Nr.936"/>
        </div>
    </div>
    <div class="d-flex flex-row">
        <div class="mb-1 w-100">
            <input type="text" class="form-control" id="nominativo" name="nominativo" value="Tel 08119918966"/>
        </div>
    </div>
    <div class="d-flex flex-row">
        <div class="mb-1 w-100">
            <input type="text" class="form-control" id="nominativo" name="nominativo" value="Email: danielazanotti@hotmail.it"/>
        </div>
    </div>
    <div class="d-flex flex-row">
        <div class="mb-1 w-100">
            <input type="text" class="form-control" id="nominativo" name="nominativo" value="Iban: IT82M0301503200000002984154"/>
        </div>
    </div>
</div>
<script>
    function generatePDF() {
        // Use AJAX to send data to the server for PDF generation
        const formData = new FormData();
        formData.append("client_name", document.getElementById("client-name").value);
        formData.append("client_address", document.getElementById("client-address").value);
        formData.append("client_city", document.getElementById("client-city").value);
        formData.append("item_description", document.getElementById("item-description").value);
        formData.append("item_amount", document.getElementById("item-amount").value);
        formData.append("tax", document.getElementById("tax").value);

        fetch("generate_pdf.php", {
            method: "POST",
            body: formData
        })
        .then(response => response.blob())
        .then(blob => {
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement("a");
            a.style.display = "none";
            a.href = url;
            a.download = "Bill.pdf";
            document.body.appendChild(a);
            a.click();
            window.URL.revokeObjectURL(url);
        })
        .catch(error => console.error("PDF generation failed:", error));
    }
</script>

</body>
</html>
