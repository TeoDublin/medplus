<?php
// bill.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customize Bill</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .form-container, .preview-container { width: 45%; float: left; margin: 2.5%; }
        .preview-container { border: 1px solid #ddd; padding: 10px; }
        .table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .table, .table th, .table td { border: 1px solid #000; padding: 8px; }
        .table th { background-color: #f2f2f2; }
        .button { margin-top: 20px; padding: 10px 20px; background-color: #4CAF50; color: white; border: none; cursor: pointer; }
    </style>
    <script>
        function updatePreview() {
            // Update client info
            document.getElementById("preview-client-name").textContent = document.getElementById("client-name").value;
            document.getElementById("preview-client-address").textContent = document.getElementById("client-address").value;
            document.getElementById("preview-client-city").textContent = document.getElementById("client-city").value;

            // Update service items and total
            const itemDescription = document.getElementById("item-description").value;
            const itemAmount = parseFloat(document.getElementById("item-amount").value) || 0;
            const tax = parseFloat(document.getElementById("tax").value) || 0;
            const totalAmount = itemAmount + tax;

            document.getElementById("preview-item-description").textContent = itemDescription;
            document.getElementById("preview-item-amount").textContent = "€ " + itemAmount.toFixed(2);
            document.getElementById("preview-tax").textContent = "€ " + tax.toFixed(2);
            document.getElementById("preview-total").textContent = "€ " + totalAmount.toFixed(2);
        }
    </script>
</head>
<body>

<div class="form-container">
    <h2>Customize Your Bill</h2>
    <form oninput="updatePreview()">
        <label for="client-name">Client Name:</label><br>
        <input type="text" id="client-name" value="Aprea Ettore"><br><br>

        <label for="client-address">Client Address:</label><br>
        <input type="text" id="client-address" value="Via F. Gaelota 23"><br><br>

        <label for="client-city">Client City:</label><br>
        <input type="text" id="client-city" value="80125 Napoli"><br><br>

        <label for="item-description">Item Description:</label><br>
        <input type="text" id="item-description" value="INTERVENTI/SEDUTE DI FISIOTERAPIA"><br><br>

        <label for="item-amount">Item Amount (€):</label><br>
        <input type="number" id="item-amount" value="90"><br><br>

        <label for="tax">Tax (€):</label><br>
        <input type="number" id="tax" value="2"><br><br>

        <button type="button" class="button" onclick="generatePDF()">Generate PDF</button>
    </form>
</div>

<div class="preview-container">
    <h2>Bill Preview</h2>
    <p><strong>Client Information:</strong></p>
    <p id="preview-client-name">Aprea Ettore</p>
    <p id="preview-client-address">Via F. Gaelota 23</p>
    <p id="preview-client-city">80125 Napoli</p>

    <table class="table">
        <tr>
            <th>Description</th>
            <th>Amount</th>
        </tr>
        <tr>
            <td id="preview-item-description">INTERVENTI/SEDUTE DI FISIOTERAPIA</td>
            <td id="preview-item-amount">€ 90.00</td>
        </tr>
        <tr>
            <td>Tax</td>
            <td id="preview-tax">€ 2.00</td>
        </tr>
        <tr>
            <td><strong>Total</strong></td>
            <td id="preview-total">€ 92.00</td>
        </tr>
    </table>
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
