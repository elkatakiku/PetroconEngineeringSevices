<?php

namespace Service;

use Core\Service;
use Model\Legend;
use Repository\LegendRepository;

class LegendService extends Service{
    
    private $legendRepository;

    public function __construct() {
        $this->legendRepository = new LegendRepository;
    }

    public function new($id, $form) {
        $cleanId = $this->sanitizeString($id);
        parse_str($form, $input);

        if (!$this->emptyInput($input) && $cleanId) 
        {
            $legend = new Legend();
            $legend->create(
                $input['color'],
                $input['title'],
                $id
            );

            if ($this->legendRepository->create($legend)) {
                $response['statusCode'] = 200;
            } else {
                $response['statusCode'] = 500;
            }
        } else {
            $response['message'] = "Fill all the required inputs.";
            $response['statusCode'] = 400;
        }

        return json_encode($response);
    }

    public function update($id, $form) {
        $cleanId = $this->sanitizeString($id);
        parse_str($form, $input);

        if ($cleanId) {
            $this->legendRepository->update($cleanId, $input);
            $response['statusCode'] = 200;
        } else {
            $response['statusCode'] = 400;
        }

        return json_encode($response);
    }

    public function remove($id) {
        $cleanId = $this->sanitizeString($id);

        if ($cleanId) {
            $response['statusCode'] = $this->legendRepository->remove($cleanId) ? 200 : 500;
        } else {
            $response['statusCode'] = 400;
        }

        return json_encode($response);
    }

    public function getList(string $id) {

        $cleanId = $this->sanitizeString($id);

        if ($cleanId) {
            if ($legends = $this->legendRepository->getAll($id, true)) {
                $response['data'] = $legends;
                $response['statusCode'] = 200;
            } else {
                $response['statusCode'] = 500;
            }
        } else {
            $response['statusCode'] = 400;
        }
        return json_encode($response);
    }
}