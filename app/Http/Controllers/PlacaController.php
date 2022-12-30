<?php

namespace App\Http\Controllers;

use App\Models\Placa;
use App\Models\Permissions;
use App\Models\SysLogs;
use App\Models\User;
use Illuminate\Http\Request;
use Auth;
use DateTime;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class PlacaController extends Controller
{

    public function __construct(Request $request)
    {
        $this->user = Auth::user();
        // $this->tabela = 'contas';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Placa::getAll($this->user->id);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $requestData = $request->all();
        $requestData['user_in'] = $this->user->id;
        $requestData['usuario_id'] = $this->user->id;


        $result =   Placa::create($requestData);
        return response()->json(['msg' => "Placa adicionado com sucesso", "conteudo" => $result], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\evento  $evento
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        Placa::getAllById($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\evento  $evento
     * @return \Illuminate\Http\Response
     */
    public function edit(Placa $evento)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\evento  $evento
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $evento =   Placa::find($id);
            $requestData = $request->all();
            $requestData['user_in'] = $this->user->id;

            $result = $evento->update($requestData);

            if ($result) {
                return response()->json(['msg' => "Placa  adicionada com sucesso", "conteudo" => $result], 201);
            } else {
                return response()->json("Falha ao incluir registro", 200);
            }
        } catch (\Exception $e) {
            return response()->json("Falha " . $e, 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\evento  $evento
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        $flight = Placa::find(1);

        $flight->delete();
    }

    public function relatorio(Request $request)
    {

        $params = $request->all();

        $usu = User::query()->where('id', $this->user->id)->first();
        if ($usu->perfil = 1) {
            $re = Placa::query()
                ->leftjoin('users', 'users.id', 'placa.usuario_id')
                ->select('placa.*')
                ->whereNull('placa.deleted_at')

                ->get();
        } else {
            $re =   Placa::query()
                ->leftjoin('users', 'users.id', 'placa.usuario_id')
                ->select('placa.*')
                ->whereNull('placa.deleted_at')
                ->where('placa.usuario_id', $this->user->id)
                ->get();
        }

       return $params;


        foreach ($re as $item) {
            $DataAtual = new DateTime($item->date);

            $item->date2 = $item->date;
            $item->date = $DataAtual->format('d/m/Y ');

            if (!empty($params['tipo'])) {

                if ($item->tipo == $params['tipo']) {
                    $data[] = $item;
                }
            }else
            if (!empty($params['placa'])) {

                if ($item->tipo == $params['placa']) {
                    $data[] = $item;
                }
            }else
            if (!empty($params['nome'])) {

                if ($item->tipo == $params['nome']) {
                    $data[] = $item;
                }
            }else{
                $data[] = $item;

            }
        }
        return $data;





        $spreadsheet = new Spreadsheet();
        $spreadsheet->setActiveSheetIndex(0);
        $sheet = $spreadsheet->getActiveSheet();
        $filename = 'Relatorio Veiculos Placas.xlsx';

        $sheet->setCellValue('A1', 'Relatorio Veiculos Placas Medb');

        $sheet->getStyle("A1:D1")->getAlignment()->setHorizontal('center');
        $sheet->getStyle("A1:D1")->getFont()->setSize(18);
        $sheet->mergeCells('A1:D1');

        $sheet->getColumnDimension('A')->setWidth(30);
        $sheet->getColumnDimension('B')->setWidth(35);
        $sheet->getColumnDimension('C')->setWidth(10);
        $sheet->getColumnDimension('D')->setWidth(15);


        // $sheet->getColumnDimension('D')->setWidth(17);
        // $sheet->getColumnDimension('E')->setWidth(15);

        $sheet->setCellValue('A3', 'Nome');
        $sheet->setCellValue('B3', 'Veiculo');
        $sheet->setCellValue('C3', 'Tipo');
        $sheet->setCellValue('D3', 'Placa');



        $sheet->getStyle("A3:D3")->getFont()->setBold(true);
        $i = 4;

        // $carteiras = $request->get('carteira');
        // return $data;
        foreach ($data as $item) {



            $sheet->setCellValue('A' . $i, $item->nome)
                ->setCellValue('B' . $i,  $item->veiculo)
                ->setCellValue('C' . $i, $item->tipo)
                ->setCellValue('D' . $i, $item->placa);



            $i++;
        }
        $sheet->getStyle("A4:D" . intval($i))->getAlignment()->setHorizontal('center');

        $sheet->getPageSetup()->setPrintArea('A1:D' . intval($i));

        $writer = new Xlsx($spreadsheet);
        $writer->save($filename);

        $file = "relatorio.xlsx"; // tive que fazer assim, estava dando erro no retorno
        return response()->download(public_path($filename));
    }
}
