<html>
    <body>
        <form method="POST" action="<?php echo base_url()?>/admin/send-invoice" enctype="multipart/form-data">
        <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>">
        <input type="hidden" name="id" value="123"/>
        <?= csrf_field(); ?>
        <input type="file" name="makan"/>
        <button type="submit">Upload</button>
        </form>
    </body>
</html>