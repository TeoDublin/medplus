<?php 
require_once 'includes.php';
require_once 'includes/header.php';?>



<div class="p-5">
    <select id="my-select">
        <option selected></option>
        <option value="test">test</option>
        <option value="test1">test1</option>
        <option value="test2">test2</option>
        <option value="test3">test3</option>
        <option value="test4">test4</option>
        <option value="test5">test5</option>
        <option value="test6">test6</option>
        <option value="test7">test7</option>
        <option value="test8">test8</option>
        <option value="test9">test9</option>
        <option value="test10">test10</option>
        <option value="test11">test11</option>
        <option value="test12">test12</option>
    </select>
</div>



<script>
 $(document).ready(function() {
    new TomSelect('#my-select');
  });

</script>