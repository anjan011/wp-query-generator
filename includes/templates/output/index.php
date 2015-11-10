<div class="me-anjan-wqg-output-block" id="<?= $idPrefix.$main->get_config( 'html/ids/generator_output' ) ?>">

    <p class="me-anjan-wqg-code-help">
        Double click on anywhere in the code to select and copy
    </p>

    <?php
        $gen = new wqg_generator( $wqgData );
        $generatedCode = $gen->generate_code();

        $generatedCode = str_replace('<','&lt;',$generatedCode);
    ?>

    <div class="me-anjan-wqg-sh-code">
        <pre class="brush: php"><?=$generatedCode?></pre>
    </div>

</div>