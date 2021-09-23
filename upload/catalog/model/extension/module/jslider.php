<?php
class ModelExtensionModuleJslider extends Model
{

    /*
     * Load a settings
     */
    public function LoadSettings() {
        $data = array();
        $data['status'] = $this->config->get('status');
        $data['display_title'] = $this->config->get('display_title');

        return $data;
    }
}
?>