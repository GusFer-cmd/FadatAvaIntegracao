<?php

namespace App\Constants;

class AccessLevels
{
    const STUDENT           = '0';   // Aluno
    const MONITOR           = '10';  // Monitor
    const TEACHER           = '20';  // Professor
    const COORDINATOR       = '40';  // Coordenador de curso
    const SUPERVISOR        = '50';  // Supervisor acadêmico
    const MANAGER           = '60';  // Gerente / administrador de setores
    const ADMIN             = '80';  // Administrador do sistema
    const SUPER_ADMIN       = '99'; // Super administrador / root
}
