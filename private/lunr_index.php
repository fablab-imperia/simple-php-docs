<?php
require_once "path_extract.php";

class LunrJson
{
    function lunr_json_generate() : string
    {
        $path = new Path();
        $path->build_from_array([]);
        $found_data = $path->_get_page_data_recursive();

        return json_encode(
            $found_data
        );
    }
    public function write_to_stdout()
    {
        header('Content-Type: application/json');
        echo $this->lunr_json_generate();
    }

    public function regenerate_file()
    {
        $out_path = __DIR__ . "/../" . "lunr_data.json";
        $data = $this->lunr_json_generate();
        file_put_contents(
            $out_path,
            $data
        );
    }
}
?>