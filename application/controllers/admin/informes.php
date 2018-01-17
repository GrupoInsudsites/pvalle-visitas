<?php
class Informes extends MY_Controller {

    public function __construct() {
        parent::__construct();
        
        $this->load->model('informe');
    }
    
    /**
     * informe de accesos
     * @param  integer $pag [description]
     * @return [type]       [description]
     */
    public function index() {
        
        $fechas['desde']                = (isset($_POST['desde']))?$_POST['desde']:'';
        $fechas['hasta']                = (isset($_POST['hasta']))?$_POST['hasta']:'';
        $fechas['tipovisita']           = (isset($_POST['tipovisita']))?$_POST['tipovisita']:'';

        $data['hasta']                  = $fechas['hasta'];
        $data['desde']                  = $fechas['desde'];
        $data['tipovisita']             = $fechas['tipovisita'];
        $filtros                        = array(
                                            'desde'         => $fechas['desde'], 
                                            'hasta'         => $fechas['hasta'],
                                            'tipovisita'    => $fechas['tipovisita']                                 

                                        );
        
        
        $data['menusel']                = "informes";
        $data['listado']                = 'admin/informe';
        $data['entradassalidas']        = $this->informe->getEntradas($filtros);
        $empresas = '';
        $emp=array(
            'vivero' => 0,
            'forestal' => 0,
            'ganaderia' => 0,
            'hotel' => 0,
            'yacare' => 0,
            'otros' =>0
            );
       
        foreach ($data['entradassalidas'] as $es) {
            if($es->vivero == 1){
                $emp['vivero'] += 1;
            }
            if($es->forestal == 1){
               $emp['forestal'] += 1;
            }
            if($es->ganaderia == 1){
                $emp['ganaderia'] += 1;
            }
            if($es->hotel == 1){
                $emp['hotel'] += 1;
            }
            if($es->yacare == 1){
                $emp['yacare'] += 1;
            }
            if($es->otros == 1){
                $emp['otros'] += 1;
            }



        }
        $data['emp'] =  $emp;

        $data['empresas'] = $empresas;
        $tot = 0;
        foreach ($emp as $key => $value) {
            $tot += $value; 
        }
        $por = array();
        foreach ($emp as $key => $value) {
            if($tot>0){
                $por[$key] = round(($value * 100) /$tot);
            }
        }

        $data['total'] =$tot;
        $data['por'] =$por;

        $data['menu_top'] = 'admin/menu_top';
         $this->load->view('admin/admin_info', $data);
    }

	public function borra_linea($id=0){
		if($this->session->userdata['id']==14 || $this->session->userdata['id']==1){
			$this->db->where('id', $id);
			$this->db->delete('entradasalida');
		}
		redirect(base_url() . 'admin/informes/index', 'location');
	}

}