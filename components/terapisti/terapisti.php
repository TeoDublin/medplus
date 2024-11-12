<?php $result=($id=request('id'))?Select('*')->from('terapisti')->where("id={$id}")->first_or_false():false;?>
<div class="p-2">
    <input type="text" id="id" name="id" value="<?php echo $result['id']??'';?>" hidden/>
    <div class="mb-3">
        <label for="terapista" class="form-label">Nome</label>
        <input type="text" class="form-control" id="terapista" name="terapista" value="<?php echo $result['terapista']??'';?>"/>
    </div>
</div>