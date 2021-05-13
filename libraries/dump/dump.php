<style>
.dump{
    background-color: #fff ;
    overflow:auto;
    margin:5px;
    box-shadow:5px 5px 10px black;
    padding:5px;
}
</style>
<?php
function dump($var){
    echo '<div class="dump">';
    var_dump($var);
    echo '</div>';
}