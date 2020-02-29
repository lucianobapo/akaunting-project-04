<?php

return [

    'success' => [
        'added'             => ':type adicionado(a)!',
        'updated'           => ':type atualizado(a)!',
        'deleted'           => ':type excluído(a)!',
        'duplicated'        => ':type duplicado(a)!',
        'imported'          => ':type importado(a)!',
        'enabled'           => ': tipo habilitado(a)!',
        'disabled'          => ': tipo desativado(a)!',
    ],

    'error' => [
        'over_payment'      => 'Erro: Pagamento não adicionado! O valor que você inseriu passa o total: :amount',
        'not_user_company'  => 'Erro: você não tem permissão para gerenciar esta empresa!',
        'customer'          => 'Erro: Endereço de email :name já esta sendo utilizado.',
        'no_file'           => 'Erro: Nenhum arquivo selecionado!',
        'last_category'     => 'Erro: Não foi possível excluir a última :type categoria!',
        'invalid_token'     => 'Erro: O símbolo inserido é inválido!',
        'import_column'     => 'Erro: :message Planilha: :sheet. Número da linha: :line.',
        'import_sheet'      => 'Erro: Planilha não é válida. Por favor, verifique o arquivo de exemplo.',
    ],

    'warning' => [
        'deleted'           => 'Aviso: Você não têm permissão para excluir <b>:name</b>, porque possui o :text relacionado.',
        'disabled'          => 'Aviso: Você não tem permissão para desativar <b>:name</b>, porque tem :text relacionado.',
        'disable_code'      => 'Aviso: você não tem permissão para desativar ou alterar a moeda de <b>:name</b> porque possui :text relacionado.',
    ],

];
