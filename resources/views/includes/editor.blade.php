<!DOCTYPE html>
<script src="https://cdn.tiny.cloud/1/twhrixacjh7gu2n28ekp4d2nvz4gr2obc0p6gq8l58lmbwba/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

<body>
  <textarea>
    Welcome to TinyMCE!
  </textarea>
  <script>
    tinymce.init({
      selector: 'textarea',
      plugins: 'a11ychecker advcode casechange export formatpainter linkchecker autolink lists checklist media mediaembed pageembed permanentpen powerpaste table advtable tinycomments tinymcespellchecker',
      toolbar: 'a11ycheck addcomment showcomments casechange checklist code export formatpainter pageembed permanentpen table',
      toolbar_mode: 'floating',
      tinycomments_mode: 'embedded',
      tinycomments_author: 'Author name',
    });
  </script>
