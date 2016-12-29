<style type="text/css">
    .logo {
        float: left;
        text-align: center;
    }
    .edit-logo {
        padding-top: 10px;
        clear: both;
    }
    .desc {
        width: 309px;
        height: 50px;
    }
    .error {
        border: 1px solid #b94a48!important;
    }
</style>
<div>
    <?php if (empty($is_supplier)) { ?>
        <?php if (empty($is_drp_team_owner)) { ?>
            <?php include display('_drp_team_detail'); ?>
        <?php } else { ?>
            <?php include display('_drp_team_edit'); ?>
        <?php } ?>
    <?php } else { ?>
        <?php include display('_drp_teams'); ?>
    <?php } ?>
</div>