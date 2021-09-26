<?php

class ControllerExtensionModuleJslider extends Controller
{
    private $error = array();
/*
 * https://code.tutsplus.com/tutorials/from-beginner-to-advanced-in-opencart-module-development--cms-21873
 * https://webformyself.com/category/cms-2/opencart-cms-2/
 * https://forum.opencart-russia.ru/threads/rukovodstvo-razrabotchika.6107/#post-44778
 */
    public function index()
    {

        $this->load->language('extension/module/jslider');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('setting/module');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            if (!isset($this->request->get['module_id'])) {
                $this->model_setting_module->addModule('jslider', $this->request->post);
            } else {
                $this->model_setting_module->editModule($this->request->get['module_id'], $this->request->post);
            }


            $this->session->data['success'] = $this->language->get('text_success');

            $this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=advertise', 'SSL'));
        }

        $data['heading_title'] = $this->language->get('heading_title');

        $data['text_edit'] = $this->language->get('text_edit');
        $data['text_enabled'] = $this->language->get('text_enabled');
        $data['text_disabled'] = $this->language->get('text_disabled');

        $data['entry_name'] = $this->language->get('entry_name');
        $data['entry_status'] = $this->language->get('entry_status');

        $data['button_save'] = $this->language->get('button_save');
        $data['button_cancel'] = $this->language->get('button_cancel');

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        if (isset($this->error['name'])) {
            $data['error_name'] = $this->error['name'];
        } else {
            $data['error_name'] = '';
        }

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_extension'),
            'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=advertise', true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('extension/module/jslider', 'user_token=' . $this->session->data['user_token'], true)
        );

        if (!isset($this->request->get['module_id'])) {
            $data['action'] = $this->url->link('extension/module/jslider', 'user_token=' . $this->session->data['user_token'], true);
        } else {
            $data['action'] = $this->url->link('extension/module/jslider', 'user_token=' . $this->session->data['user_token'] . '&module_id=' . $this->request->get['module_id'], true);
        }

        $data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true);

        if (isset($this->request->get['module_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            $module_info = $this->model_setting_module->getModule($this->request->get['module_id']);
        }

        if (isset($this->request->post['name'])) {
            $data['name'] = $this->request->post['name'];
        } elseif (!empty($module_info)) {
            $data['name'] = $module_info['name'];
        } else {
            $data['name'] = '';
        }
        $data['name'] = htmlspecialchars($data['name']);

        if (isset($this->request->post['display_title'])) {
            $data['display_title'] = $this->request->post['display_title'];
        } elseif (!empty($module_info)) {
            $data['display_title'] = $module_info['display_title'];
        } else {
            $data['display_title'] = '';
        }

        if (isset($this->request->post['add_span'])) {
            $data['add_span'] = $this->request->post['add_span'];
        } elseif (!empty($module_info)) {
            $data['add_span'] = $module_info['add_span'];
        } else {
            $data['add_span'] = '';
        }

        if (isset($this->request->post['hclass'])) {
            $data['hclass'] = $this->request->post['hclass'];
        } elseif (!empty($module_info)) {
            $data['hclass'] = $module_info['hclass'];
        } else {
            $data['hclass'] = '';
        }
        $data['hclass'] = htmlspecialchars($data['hclass']);

        if (isset($this->request->post['status'])) {
            $data['status'] = $this->request->post['status'];
        } elseif (!empty($module_info)) {
            $data['status'] = $module_info['status'];
        } else {
            $data['status'] = '';
        }

        if (isset($this->request->post['banner_id'])) {
            $data['banner_id'] = $this->request->post['banner_id'];
        } elseif (!empty($module_info)) {
            $data['banner_id'] = $module_info['banner_id'];
        } else {
            $data['banner_id'] = '';
        }

        $this->load->model('design/banner');

        $data['banners'] = $this->model_design_banner->getBanners();

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('extension/module/jslider', $data));
    }

    protected function validate()
    {
        if (!$this->user->hasPermission('modify', 'extension/module/jslider')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 64)) {
            $this->error['name'] = $this->language->get('error_name');
        }

        return !$this->error;
    }
}