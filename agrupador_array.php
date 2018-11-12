 <?php 
/*
Agrupador de array por chave (índice) informado
*/
 public function agrupador_array(array $array, $chave)
 {
        if (!is_string($chave) && !is_int($chave) && !is_float($chave) && !is_callable($chave) ) 
        {
            trigger_error('agrupador_array(): A chave precisa ser uma string ou inteiro', E_USER_ERROR);
            return null;
        }

        $func = (!is_string($chave) && is_callable($chave) ? $chave : null);
        $_chave = $chave;

        $agrupado = [];
        
        foreach ($array as $valor) 
        {
            $chave = null;
            if (is_callable($func)) 
            {

                $chave = call_user_func($func, $valor);
            } 
            elseif (is_object($valor) && isset($valor->{$_chave})) 
            {
                $chave = $valor->{$_chave};
            } 
            elseif (isset($valor[$_chave])) 
            {
                $chave = $valor[$_chave];
            }
            if ($chave === null) 
            {
                continue;
            }
            $agrupado[$chave][] = $valor;
        }

        if (func_num_args() > 2) 
        {
            $args = func_get_args();
            foreach ($agrupado as $chave => $valor) 
            {
                $params = array_merge([ $valor ], array_slice($args, 2, func_num_args()));
                $agrupado[$chave] = call_user_func_array('agrupador_array', $params);
            }
        }
        return $agrupado;
 }
