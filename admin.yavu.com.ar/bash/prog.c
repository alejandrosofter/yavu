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
   	char cadena[100];
   	/* EN test se ecuentra el programa que hace los movimientos de archivos */
   	strcpy(cadena,"/var/www/yavu.com.ar/bash/test ");
 	strcat(cadena,argv[1]);
 	strcat(cadena," ");
 	strcat(cadena,argv[2]);
   	system(cadena );

   	return 0;
}
