#!/bin/bash

COMMAND="java -jar trusted-app-client-0.0.1-jar-with-dependencies2.jar -action l -id camicSignup -secret 9002eaf56-90a5-4257-8665-6341a5f77107  -url http://quip-data:9099/trustedApplication"
#echo $COMMAND
eval $COMMAND
