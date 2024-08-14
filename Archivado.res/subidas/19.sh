#!/bin/bash

# Limpiamos pantalla
clear >$(tty)

# Datos del atacante
read -p "Destreza del atacante: " DesAtk
read -p "Habilidad del cuerpo a cuerpo que se esté usando: " HabCac
read -p "Resultado de la tirada del D10: " tiradaAtk

# Resolución del atacante
let atacante=$DesAtk+$HabCac+$tiradaAtk

clear >$(tty)

# Datos del defensor
read -p "Destreza del defensor: " DesDef
read -p "Evasión del defensor: " EvDef
read -p "Resultado de la tirada del D10: " tiradaDef

# Resolución del defensor
let defensor=$DesDef+$EvDef+$tiradaDef

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
