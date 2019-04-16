<?php
/**
 * Copyright (c) 2015 Creative Commons Corportation
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 * http://www.gnu.org/copyleft/gpl.html
 */

require_once __DIR__ . '/Maintenance.php';

class AddCCIDUser extends Maintenance {

    public function __construct() {
    	   parent::__construct();
		$this->mDescription = "Create a new CCID user account for Teamspace.";

        #$this->addArg( "global", "CCID global identifier of new user" );
        $this->addArg( "email", "CCID email of new user (will be used as user name as well)" );
	$this->addArg( "name", "Real name of user" );
    }

    public function execute() {
        global $CASAuth;

        if (! isset( $CASAuth )) {
            $this->error('$CASAuth not set in LocalSettings.php', true);
        }

        $name = $global = $this->getArg( 1 );
        $casuid = $email = $this->getArg( 0 );
        $ccid_name = ucfirst ( $email );

        $u = User::newFromName( $ccid_name );
        // Create a new account if the user does not exists
        if ($u->getID() != 0) {
            $this->error("User already exists", true);
            exit(1);
        } else {
            //$nickname = $attr['nickname'];
            // Create the user
            $u->addToDatabase();
            $u->setRealName($name);
            $u->setEmail($casuid);
            $u->confirmEmail();
            $u->setPassword( md5($casuid.$CASAuth["PwdSecret"]) ); //PwdSecret is used to salt the casuid, which is then used to create an md5 hash which becomes the password
            $u->setToken();
            $u->saveSettings();
            // Update user count
            $ssUpdate = new SiteStatsUpdate( 0, 0, 0, 0, 1 );
            $ssUpdate->doUpdate();
        }
    }
}

$maintClass = "AddCCIDUser";
require_once RUN_MAINTENANCE_IF_MAIN;
