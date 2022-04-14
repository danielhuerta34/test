<div class="row pdocrud-filters-container" data-objkey="<?php echo $objKey; ?>" >
    <div class="col-sm-12">
        <?php if (isset($filters) && count($filters)) { ?>
            <div class="pdocrud-filters-options" style="text-align: center; margin-bottom: 15px;">
                <div class="pdocrud-filter-selected">
                    <span class="pdocrud-filter-option-remove btn btn-success"><i class="fa fa-paint-brush"></i> <?php echo $lang["clear_all"] ?></span>
                    <br><br>
                </div>
                <?php
                foreach ($filters as $filter) {
                    echo $filter;
                }
                ?>
            </div>
            <?php
        }
        ?>
    </div>
     <div class="col-sm-12">
        <?php echo $data ?>
    </div>
</div>