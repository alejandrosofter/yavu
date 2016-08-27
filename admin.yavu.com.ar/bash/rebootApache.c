#include <stdio.h>
#include <stdlib.h>
#include <sys/types.h>
#include <unistd.h>
#include <string.h>
/* PARA COMPILAR EL PROGRAMA */
/* gcc runscript.c -o scr */
/* chmod 4755 scr */
int main(int argc, char **argv)
{
   	setuid( 0 );
   	system("sudo service apache2 reload");

   	return 0;
}
