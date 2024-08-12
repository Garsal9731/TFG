#!/bin/bash

# Limpiamos pantalla
clear >$(tty)

PS3='Dificultad del checkeo (Pag.129): '
opciones=("Simple" "Común" "Difícil" "Profesional" "Heroico" "Increíble" "Legendario")
select opcion in "${opciones[@]}"
do
    case $opcion in
        "Simple")

                let base=9
                break
            ;;
        "Común")
		let base=13
                break
            ;;
	"Difícil")
                let base=15
                break
            ;;
	"Profesional")
                let base=17
                break
            ;;
	"Heroico")
                let base=21
                break
	    ;;
	"Increíble")
	        let base=24
	        break
	    ;;
	"Legendario")
                let base=29
                break
            ;;
        *) echo "Opción Invalida";;
    esac
done
