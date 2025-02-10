#!/bin/bash

# Limpiamos pantalla
clear >$(tty)

PS3='¿Como se va a defender?: '
opciones=("Por distancia" "Esquivar (8 o más de reflejos)")
select opcion in "${opciones[@]}"
do
    case $opcion in
        "Por distancia")

		clear >$(tty)

            	read -p "Checkeo dependiendo de la distancia y el arma (Pag. 173): " check
		let defensor=$check

		break
            ;;
        "Esquivar (8 o más de reflejos)")

		clear >$(tty)

		# Datos del defensor
		read -p "Destreza del defensor: " DesDef
		read -p "Evasión del defensor: " EvDef
		read -p "Resultado de la tirada del D10: " tiradaDef

		# Resolución del defensor
		let defensor=$DesDef+$EvDef+$tiradaDef

		break
            ;;
        *) echo "Opción Invalida";;
    esac
done

clear >$(tty)

# Datos del atacante
read -p "Reflejos del atacante: " RefAtk
read -p "Habilidad del arma que se está usando: " HabArma
read -p "Resultado de la tirada del D10: " tiradaAtk

# Resolución del atacante
let atacante=$RefAtk+$HabArma+$tiradaAtk

clear >$(tty)

# Si la resolución del atacante es mayor que la del defensor le acierta
if [ $atacante -gt $defensor ]
	then
		echo "¡Ha acertado el atacante!"
fi

# Si la resolución del defensor es mayor el defensor esquiva el disparo
if [ $defensor -gt $atacante ]
	then
		echo "¡El defensor ha esquivado!"
fi

# En caso de empate gana el defensor
if [ $atacante -eq $defensor ]
	then
		echo "¡El defensor ha esquivado!"
fi
