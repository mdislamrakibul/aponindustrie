<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SyncUserLoginData extends Command
{
    protected $signature   = 'sync:user-login {--dry-run : Preview changes without writing}';
    protected $description = 'One-time backfill: copy User (tbl_info_user) values into matching Login (tbl_info_login) rows via User.login_id = Login.id';

    public function handle(): int
    {
        $dryRun = $this->option('dry-run');

        // Join on tbl_info_user.login_id = tbl_info_login.id
        $rows = DB::table('tbl_info_login as l')
            ->join('tbl_info_user as u', 'u.login_id', '=', 'l.id')
            ->select(
                'l.id   as login_id',
                'l.first_name as l_first',  'u.first_name as u_first',
                'l.last_name  as l_last',   'u.last_name  as u_last',
                'l.phone      as l_phone',  'u.mobile_no  as u_phone',
                'l.role       as l_role',   'u.role       as u_role',
                'l.status     as l_status', 'u.status     as u_status'
            )
            ->get();

        $count = 0;

        foreach ($rows as $row) {
            $patch = [];

            if ($row->l_first  !== $row->u_first)  $patch['first_name'] = $row->u_first;
            if ($row->l_last   !== $row->u_last)   $patch['last_name']  = $row->u_last;
            if ($row->l_phone  !== $row->u_phone)  $patch['phone']      = $row->u_phone;
            if (strtolower((string) $row->l_role)   !== strtolower((string) $row->u_role))   $patch['role']   = strtolower($row->u_role);
            if (strtolower((string) $row->l_status) !== strtolower((string) $row->u_status)) $patch['status'] = $row->u_status;

            if (!empty($patch)) {
                $patch['name'] = trim(
                    ($patch['first_name'] ?? $row->l_first) . ' ' .
                    ($patch['last_name']  ?? $row->l_last)
                );

                $this->line("Login #{$row->login_id}: " . json_encode($patch));

                if (!$dryRun) {
                    DB::table('tbl_info_login')
                        ->where('id', $row->login_id)
                        ->update($patch);
                }

                $count++;
            }
        }

        $label = $dryRun ? 'Would update' : 'Updated';
        $this->info("{$label} {$count} login row(s) out of {$rows->count()} linked pair(s).");

        return self::SUCCESS;
    }
}
