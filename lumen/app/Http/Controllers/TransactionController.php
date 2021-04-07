<?php

namespace App\Http\Controllers;

use App\Models\Usuarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TransactionController extends Controller
{
    public function transaction(Request $request)
    {
        $dados = $request->all();
        
        $pagador_id = $dados['payer'];
        $recebedor_id = $dados['payee'];
        $valor = $dados['value'];
        $pagador = Usuarios::find($pagador_id);
        $recebedor = Usuarios::find($recebedor_id);
        
        //Verificando se pagador e recebedor existem, e se pagador é lojista.
        if ($pagador){
            if ($pagador->cnpj){
                return "Lojistas só recebem transferências";
            }         
        } else {
            return "Pagador não encontrado!";
        }

        if (!$recebedor){
            return "Recebedor não encontrado!";
        }
        
        //Se pagador tem saldo disponível
        if($pagador->conta >= $valor){
            
            //Autorização
            $auth = Http::get('https://run.mocky.io/v3/8fafdd68-a090-496f-8c9a-3442cf30dae6');
            $response = json_decode($auth->body());//Decodificando Json.

            if($auth->status() == 200 && $response->message == "Autorizado"){
                $saldo_pagador = $pagador->conta - $valor;
                $saldo_recebedor = $recebedor->conta + $valor;

                //Update na tabela Usuarios, campo conta.
                Usuarios::find($pagador_id)->update(['conta'=>$saldo_pagador]);
                Usuarios::find($recebedor_id)->update(['conta'=>$saldo_recebedor]);
                
                return $this->notificar();
                                
            } else {
                return "Não autorizado";
            }          
            
        } else {
            return "Saldo insuficiente";
        }
    }

    private function notificar()
    {
        //Notificação
        $notify = Http::get('https://run.mocky.io/v3/b19f7b9f-9cbf-4fc6-ad22-dc30601aec04');
        $response = json_decode($notify->body());

        if($notify->status() == 200 && $response->message == "Enviado"){
            return "Transferência realizada com sucesso!";
        } else {
            return "Transferência realizada com sucesso!";
        }
    }
}