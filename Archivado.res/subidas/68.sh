#!/bin/bash

# Limpiamos pantalla
clear >$(tty)

PS3='Tipo de ataque: '
opciones=("Programa" "Zap")
select opcion in "${opciones[@]}"
do
    case $opcion in
        "Programa")

		clear >$(tty)

                # Datos del atacante
		read -p "Tirada de Interfaz del atacante: " intAtk
		read -p "ATK del programa: " AtkPro
		read -p "Tirada de D10 o ATK de Hielo Negro: " AtkHielo
		read -p "Tirada de D10: " tiradaAtk

		# Resolución del atacante
		let atacante=$intAtk+$AtkPro+$tiradaAtk+$AtkHielo

		clear >$(tty)

		# Datos del defensor
		read -p "Tirada de Interfaz del defensor: " intDef
		read -p "Tirada D10, Defensa Programa o Defensa Hielo Negro: " DefHielo
		read -p "Tirada del D10: " tiradaDef

		# Resolución del defensor
		let defensor=$intDef+$DefHielo+$tiradaDef

                break
            ;;
        "Zap")

                clear >$(tty)

		echo "SI ACIERTA ZAPEO TIRA 1D6 DE DAÑO CONTRA EL ENEMIGO."

		# Tirada del atacante usando zapeo
		read -p "Tirada de zapeo: " atacante

		clear >$(tty)

                # Datos del defensor
                read -p "Defensa del programa: " DefPro
                read -p "Tirada D10 o Tirada de interfaz: " tiradaProDef
                read -p "Resultado de la tirada del D10: " tiradaDef

                # Resolución del defensor
                let defensor=$DefPro+$tiradaProDef+$tiradaDef

                break
            ;;
        *) echo "Opción Invalida";;
    esac
done

clear >$(tty)

# Si la resolución del atacante es mayor que la del defensor le acierta
if [ $atacante -gt $defensor ]
        then
                echo "¡El atacante hackea!"
fi

# Si la resolución del defensor es mayor el defensor esquiva el disparo
if [ $defensor -gt $atacante ]
        then
                echo "¡El defensor ha bloqueado!"
fi

# En caso de empate gana el defensor
if [ $atacante -eq $defensor ]
        then
                echo "¡El defensor ha bloqueado!"
fi
