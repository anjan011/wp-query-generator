<div class="me-anjan-wqg-output-block" id="<?= $idPrefix.$main->getConfig( 'html/ids/generator_output' ) ?>">

    <p class="me-anjan-wqg-code-help clearfix">
        Double click on anywhere in the code to select and copy <button type="button" class="button-secondary me-anjan-wqg-btn-preview">Preview
            Data
        </button>
    </p>

    <?php
        $gen = new meAnjanWqg_Generator( $wqgData );
        $generatedCode = $gen->generateCode();

        $generatedCode = str_replace('<','&lt;',$generatedCode);
    ?>

    <div class="me-anjan-wqg-sh-code">
        <pre class="brush: php"><?=$generatedCode?></pre>
    </div>

</div>