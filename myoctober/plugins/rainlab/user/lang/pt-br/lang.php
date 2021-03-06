<?php

return [
    'plugin' => [
        'name' => 'Usuário',
        'description' => 'Gerenciamento de usuários de front-end.'
    ],
    'location' => [
        'label' => 'Local',
        'new' => 'Novo Local',
        'create_title' => 'Criar Local',
        'update_title' => 'Editar Local',
        'preview_title' => 'Pré-visualizar Local'
    ],
    'locations' => [
        'menu_label' => 'Locais',
        'menu_description' => 'Gerenciar países e estados disponíveis.',
        'hide_disabled' => 'Ocultar desabilitados',
        'enabled_label' => 'Habilitado',
        'enabled_help' => 'Locais desabilitados não são visíveis no front-end.',
        'enable_or_disable_title' => "Habilitar ou Desabilitar Locais",
        'enable_or_disable' => 'Habilitar ou Desabilitar',
        'selected_amount' => 'Locais selecionados :amount',
        'enable_success' => 'Locais habilitados com sucesso.',
        'disable_success' => 'Locais desabilitados com sucesso.',
        'disable_confirm' => 'Você tem certeza?',
        'list_title' => 'Gerenciar Locais',
        'delete_confirm' => 'Você realmente deseja deletar este local?',
        'return_to_list' => 'Retornar à lista de locais'
    ],
    'users' => [
        'menu_label' => 'Usuários',
        'all_users' => 'Todos Usuários',
        'new_user' => 'Novo Usuário',
        'list_title' => 'Gerenciar Usuários',
        'activating' => 'Ativando...',
        'activate_warning_title' => 'Usuário não ativado!',
        'activate_warning_desc' => 'Este usuário não foi ativado e estará impossibilitado de logar-se.',
        'activate_confirm' => 'Você realmente deseja ativar este usuário?',
        'active_manually' => 'Ativar este usuário manualmente',
        'delete_confirm' => 'Você realmente deseja deletar este usuário?',
        'activated_success' => 'O usuário foi ativado com sucesso!',
        'return_to_list' => 'Retornar à lista de usuários',
        'delete_selected_empty' => 'Não há usuários selecionados para deletar.',
        'delete_selected_confirm' => 'Deletar os usuários selecionados?',
        'delete_selected_success' => 'Usuários selecionados deletados com sucesso.',
    ],
    'settings' => [
        'users' => 'Usuários',
        'menu_label' => 'Configurações de usuário',
        'menu_description' => 'Gerenciar configurações relacionadas a usuários.',
        'activation_tab' => 'Ativação',
        'location_tab' => 'Local',
        'signin_tab' => 'Login',
        'activate_mode' => 'Modo de ativação',
        'activate_mode_comment' => 'Selecione como uma conta de usuário deve ser ativada.',
        'activate_mode_auto' => 'Automática',
        'activate_mode_auto_comment' => 'Ativada automaticamente mediante o cadastro.',
        'activate_mode_user' => 'Usuário',
        'activate_mode_user_comment' => 'O usuário ativa sua própria conta usando o e-mail.',
        'activate_mode_admin' => 'Administrador',
        'activate_mode_admin_comment' => 'Apenas um Administrador pode ativar um usuário.',
        'welcome_template' => 'Modelo de Boas Vindas',
        'welcome_template_comment' => 'Modelo de e-mail a ser enviado ao usuário quanto ele é ativado.',
        'require_activation' => 'Login requer ativação',
        'require_activation_comment' => 'Usuários precisam ter uma conta ativada para logar.',
        'default_country' => 'País padrão',
        'default_country_comment' => 'Quando um usuário não especifica seu local, selecione um país padrão para usar.',
        'default_state' => 'Estado padrão',
        'default_state_comment' => 'Quando um usuário não especifica seu local, selecione um estado padrão para usar.',
        'use_throttle' => 'Tentativas limitadas',
        'use_throttle_comment' => 'Tentativas repetidas de login mal-sucedidas suspenderão temporariamente o usuário.',
        'login_attribute' => 'Atributo para login',
        'login_attribute_comment' => 'Selecione qual atributo do usuário deve ser usado para logar.',
        'no_mail_template' => 'Não enviar uma notificação',
        'hint_templates' => 'Você pode customizar modelos de e-mail selecionando E-mail > Modelos de E-mail no menu de configurações.'
    ],
    'state' => [
        'label' => 'Estado',
        'name' => 'Nome',
        'name_comment' => 'Informe do nome de exibição para este estado.',
        'code' => 'Código',
        'code_comment' => 'Informe o código único pra este estado.'
    ],
    'country' => [
        'label' => 'País',
        'name' => 'Nome',
        'code' => 'Código',
        'code_comment' => 'Informe um código único para este país.',
        'enabled' => 'Habilitado'
    ],
    'user' => [
        'label' => 'Usuário',
        'id' => 'ID',
        'username' => 'Nome de usuário',
        'name' => 'Nome',
        'surname' => 'Sobrenome',
        'email' => 'E-mail',
        'created_at' => 'Registrado',
        'phone' => 'Telefone',
        'company' => 'Empresa',
        'city' => 'Cidade',
        'zip' => 'CEP',
        'street_addr' => 'Endereço',
        'country' => 'País',
        'select_country' => '-- selecione um país --',
        'state' => 'Estado',
        'select_state' => '-- selecione um estado --',
        'reset_password' => 'Resetar senha',
        'reset_password_comment' => 'Para resetar a senha deste usuário, informe uma nova senha aqui.',
        'confirm_password' => 'Confirmação de Senha',
        'confirm_password_comment' => 'Informe a senha novamente para confirmá-la.',
        'avatar' => 'Avatar',
        'details' => 'Detalhes',
        'account' => 'Conta'
    ],
    'login' => [
        'attribute_email' => 'E-mail',
        'attribute_username' => 'Nome de usuário'
    ],
    'account' => [
        'account' => 'Conta',
        'account_desc' => 'Formulário de gerenciamento de usuário.',
        'redirect_to' => 'Redirecionar para',
        'redirect_to_desc' => 'Nome da página para a qual redirecionar após atualização, login ou cadastro.',
        'code_param' => 'Parâmetro de Código de Ativação',
        'code_param_desc' => 'O parâmetro de URL da página usado para o código de ativação de cadastro',
        'invalid_activation_code' => 'Código de ativação informado inválido',
        'invalid_user' => 'Não foi encontrado um usuário com as credenciais informadas.',
        'success_activation' => 'Sua conta foi ativada com sucesso.',
        'success_saved' => 'Configurações salvas com sucesso!',
        'login_first' => 'Você precisa se logar primeiro!',
        'alredy_active' => 'Sua conta já está ativada!',
        'activation_email_sent' => 'E-mail de ativação foi enviado para o endereço de e-mail informado.',
        'country' => 'País',
        'state' => 'Estado',
        'sign_in' => 'Login',
        'register' => 'Cadastrar-se',
        'full_name' => 'Nome Completo',
        'email' => 'E-mail',
        'password' => 'Senha',
        'register' => 'Cadastrar-se',
        'login' => 'Login',
        'address' => 'Endereço',
        'city_suburb' => 'Cidade / Município',
        'postal_code' => 'Código Postal',
        'new_password' => 'Nova Senha',
        'new_password_confirm' => 'Confirmar Nova Senha'
    ],
    'reset_password' => [
        'reset_password' => 'Resetar Senha',
        'reset_password_desc' => 'Formulário de senha esquecida.',
        'code_param' => 'Parâmetro de código para resetar senha ',
        'code_param_desc' => 'O parâmetro de URL da página usado para o código'
    ],
    'session' => [
        'session' => 'Sessão',
        'session_desc' => 'Adiciona a sessão do usuário a uma página e pode restringir o acesso à página.',
        'security_title' => 'Permitir apenas',
        'security_desc' => 'Quem tem permissão para acessar esta página.',
        'all' => 'Todos',
        'users' => 'Usuários',
        'guests' => 'Visitantes',
        'redirect_title' => 'Redirecionar para',
        'redirect_desc' => 'Nome da página para qual redirecionar se o acesso for negado.'
    ]
];
