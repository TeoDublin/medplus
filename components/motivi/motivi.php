<?php $result=($id=request('id'))?$result=Select('*')->from('motivi')->where("id={$id}")->first_or_false():false;?>
<div class="p-2">
    <input type="text" id="id" name="id" value="<?php echo $result['id']??'';?>" hidden/>
    <div class="mb-3">
        <div class="mb-3">
            <label for="motivo" class="form-label">Motivo</label>
            <input type="text" class="form-control" id="motivo" name="motivo" value="<?php echo $result['motivo']??'';?>"/>
        </div>
    </div>
</div>