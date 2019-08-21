<?php
require_once(CONTROLLERS_DIR . 'BaseController.php');

class Categorias extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('categoria_helper');
        carregar_dependencias();
    }

    public function index()
    {
        $method = parent::detectar_acao();
        if ($method === "GET") {
            $resultado_query = $this->categoria->get_todos('descricao');
            echo json_encode($resultado_query);
        }
    }

    private function valida($categoria, $edicao)
    {
        $this->form_validation->set_data($categoria);
        $this->form_validation->set_rules('descricao', 'Descrição', 'required');
        if ($edicao) {
            $this->form_validation->set_rules('id', 'Identificação', 'is_natural_no_zero');
        }
        return $this->form_validation->run();
    }

    protected function persistir($categoria)
    {
        $id = 0;
        $validacao = $this->valida((array) $categoria, false);
        $msg = "Categoria Salva.";

        if ($validacao) {
            $id = $this->categoria->persistir((array)$categoria);
        } else {
            $msg = validation_errors();
        }
        
        echo parent::resposta_json($id > 0, $msg, null);
    }

    protected function remover($categoria)
    {
        $id = 0;
        $validacao = $this->valida((array) $categoria, true);
        $possui_cursos = $this->categoria->possui_cursos_vinculados($categoria->id);
        $msg = "Categoria ".$categoria->descricao." Removida.";

        if (!$possui_cursos) {
            if ($validacao) {
                $id = $this->categoria->remover((array)$categoria);
            } else {
                $msg = validation_errors();
            }
        }
        else
             $msg = "Categoria ".$categoria->descricao." possui Cursos vinculados";

        echo parent::resposta_json($id > 0, $msg, null);
    }
}
