<?php

namespace App\Tzevent\Service\MetierManagerBundle\Utils;

/**
 * Class RoleName
 * Classe qui contient les noms constante des rôles utilisateur
 */
class RoleName
{
    // Nom rôle
    const ROLE_SUPER_ADMINISTRATEUR = 'ROLE_SUPERADMIN';
    const ROLE_ADMINISTRATEUR       = 'ROLE_ADMIN';
    const ROLE_MEMBER  = 'ROLE_MEMBER';

    // Identifiant rôle
    const ID_ROLE_SUPERADMIN  = 1;
    const ID_ROLE_ADMIN       = 2;
    const ID_ROLE_MEMBER      = 3;

    static $ROLE_TYPE = array(
        'Admin'       => 'ROLE_ADMIN',
        'Member'      => 'ROLE_MEMBER',
        'Superadmin'  => 'ROLE_SUPERADMIN'
    );
}
