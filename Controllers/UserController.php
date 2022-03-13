<?php

class UserController extends BaseController
{
    public function read()
    {
        $strErrDesc = '';
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        $arrQueryStringParams = $this->getQueryStringParams();

        if(strtoupper($requestMethod) == 'GET') {
            try {
                $userModel = new UserModel();

                $intLimit = 10;
                if(isset($arrQueryStringParams['limit']) && $arrQueryStringParams['limit']) {
                    $intLimit = $arrQueryStringParams['limit'];
                }

                $arrUsers = $userModel->getUsers($intLimit);
                $responseData = json_encode($arrUsers);
            } catch(Exception $e) {
                $strErrDesc = $e->getMessage() . ' Something went wrong! Contact Aaron';
                $strErrHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else {
            $strErrDesc = 'Method not supported';
            $strErrHeader = 'HTTP/1.1 422 Uprocessable Entity';
        }

        // send output
        if(!$strErrDesc) {
            $this->sendOutput(
                $responseData,
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        } else {
            $this->sendOutput(
                json_encode(array('error' => $strErrDesc)),
                array('Content-Type: application/json', $strErrHeader)
            );
        }
    }
}