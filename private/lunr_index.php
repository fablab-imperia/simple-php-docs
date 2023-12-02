<?php
require_once "path_extract.php";

class LunrJson
{
    function lunr_json_generate() : string
    {
        $path = new Path();
        $path->build_from_array([]);
        return json_encode(
            $path->_get_page_data_recursive()
        );
    }
    public function write_to_stdout()
    {
        header('Content-Type: application/json');
        echo $this->lunr_json_generate();
    }

    public function regenerate_file()
    {
        $path = new Path();
        $path->build_from_array([]);
        file_put_contents(
            __DIR__ . "/../" . "lunr_data.json",
            $this->lunr_json_generate()
        );
    }
}
?>