<head>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>

<body class="p-4">
  <a data-bs-toggle="modal" href="#myModal" class="btn btn-primary">Launch modal</a>

<div class="modal" id="myModal" style="display: none;" aria-hidden="true">
	<div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Modal title</h4>
          <button type="button" class="btn-close" onclick="closeModal(this);" aria-label="Close"></button>
        </div><div class="container"></div>
        <div class="modal-body">
          Content for the dialog / modal goes here.
         <a href="#" class="btn btn-primary" onclick="openMyModal2()">Launch (my)modal(2)</a>
        </div>
        <div class="modal-footer">
          <a href="#" class="btn btn-outline-dark">Close</a>
        </div>
      </div>
    </div>
</div>
<div class="modal bg-dark bg-opacity-50" id="myModal2" data-bs-backdrop="static" style="display: none;" aria-hidden="true">
	<div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">2nd Modal title</h4>
          <button type="button" class="btn-close" onclick="closeModal(this);" aria-label="Close"></button>
        </div><div class="container"></div>
        <div class="modal-body">
          Content for the dialog / modal goes here.
          Content for the dialog / modal goes here.
          Content for the dialog / modal goes here.
          Content for the dialog / modal goes here.
          Content for the dialog / modal goes here.
        </div>
        <div class="modal-footer">
          <a href="#" class="btn btn-outline-dark">Close</a>
          <a href="#" class="btn btn-primary">Save changes</a>
        </div>
      </div>
    </div>
</div>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script>
         function openMyModal2() {
        let myModal = new
                bootstrap.Modal(document.getElementById('myModal2'), {});
        myModal.show();
    }
    </script>
</body>