<?php

namespace Org\Jvhsa\Surgiscript\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\QueryException;
use Org\Jvhsa\Surgiscript\Role;
use Org\Jvhsa\Surgiscript\User;

class MakeAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:admin {email*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Registers a user as an admin';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $admin_role = Role::where('name', '=', 'admin')->first();

        if(empty($admin_role)){
            $this->info("Admin role is not defined. Please run migration first");
            return;
        }

        foreach ($this->argument('email') as $key => $value) {
            // Look for users' with the email
            $found = User::where('email' , '=', $value)->first();

            if(!empty($found)){
                $this->info("User with email " . $value . " was found.");
                $this->info("Assigning admin role to the user");

                try{
                    $found->attachRole($admin_role);
                }catch(\Exception $e){
                    $this->info("User with email " . $value . " already has appropriate roles");
                }
            }else{
                $this->info("User with email " . $value . " was NOT found.");
            }
        }
    }
}
