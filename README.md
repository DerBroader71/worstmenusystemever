# worstmenusystemever
A bash/PHP menu system based on .ssh/config file

I have a very large .ssh/config file setup as below but with many entries.


     Host [SHORTNAME]

         Hostname [IP or FQDN]

         User [USER.NAME]

         IdentityFile [KEY FILE LOCATION]
     
     
Initially I setup an alias to list all the hosts and make it an easy copy and paste

alias listssh='grep "Host " ~/.ssh/config | sed "s/Host/ssh/g"'

As the server it was going to be used on is just a jump-host to other systems, I decided to make a basic menu system that would be invoked on login.

And this is the terrible solution I came up with.
