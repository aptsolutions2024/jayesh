COUNT FOR PFrate>0 TO FPFEMP
ADMPF=ROUND((MGRSAL*0.0065),2)
LINKINS=ROUND((MGRSAL*0.0050),0)
ADMLINK=ROUND((MGRSAL*0.00010),2)
if VAL(SUBSTR(STR(admpf,7,2),7,1))>0 .AND. VAL(SUBSTR(STR(admpf,7,2),7,1))<5
   admpf=VAL(SUBSTR(STR(admpf,7,2),1,6)+"5")                    
endif
if SUBSTR(STR(admpf,7,2),7,1)>"5"
   admpf=VAL(SUBSTR(STR(admpf,7,2),1,6)+"0")+0.10
endif
if VAL(SUBSTR(STR(admlink,7,2),7,1))>0 .AND. VAL(SUBSTR(STR(admlink,7,2),7,1))<5
   admlink=VAL(SUBSTR(STR(admlink,7,2),1,6)+"5")
endif
if SUBSTR(STR(admlink,7,2),7,1)>"5"
   admlink=VAL(SUBSTR(STR(admlink,7,2),1,6)+"0")+0.10
endif
if admlink>0 .and. admlink<2
   admlink=2.00
endif
SET DEVICE TO PRINT
SET MARGIN TO 10
@ 1,round((58-len(clientname))/2,0) SAY clientname
@ 2,round((58-len(HEADING1))/2,0) SAY HEADING1
@ 3,round((58-len(MPERIOD))/2,0) SAY MPERIOD
@ 4,1 SAY "----------------------------------------------------------"
@ 5,1 SAY "Particulars                                     Amount Rs."
@ 6,1 SAY "--------------------------------------------  ------------"
@ 7,1 SAY "Gross salary"
@ 7,48 SAY MGRSAL PICTURE "9,99,999.99"
@ 9,1 SAY "P.F.   - Employees' contribution"
@ 9,48 SAY PF1 PICTURE "9,99,999.99"
@ 11,1 SAY "F.P.F. - Employees' contribution"
@ 11,48 SAY FPF1 PICTURE "9,99,999.99"
@ 13,1 SAY "P.F.   - Employer's contribution"
@ 13,48 SAY PF2 PICTURE "9,99,999.99"
@ 15,1 SAY "F.P.F. - Employer's contribution"
@ 15,48 SAY FPF2 PICTURE "9,99,999.99"
@ 17,1 SAY "P.F.   - Total      contribution"
@ 17,48 SAY PF1+PF2 PICTURE "9,99,999.99"
@ 19,1 SAY "F.P.F. - Total      contribution"
@ 19,48 SAY FPF1+FPF2 PICTURE "9,99,999.99"
@ 21,1 SAY "Administration charges on P.F."
@ 21,48 SAY ADMPF PICTURE "9,99,999.99"
@ 23,1 SAY "Link Insurance"
@ 23,48 SAY LINKINS PICTURE "9,99,999.99"
@ 25,1 SAY "Administration charges on Link Insurance"
@ 25,48 SAY ADMLINK PICTURE "9,99,999.99"
@ 27,1 SAY "Total amount payable"
@ 27,48 SAY PF1+PF2+FPF1+FPF2+ADMPF+LINKINS+ADMLINK PICTURE "9,99,999.99"
@ 30,1 SAY "Total no.of employees"
@ 30,48 SAY RECCOUNT() PICTURE "9,99,999"
@ 32,1 SAY "No.of employees under P.F. / F.P.F."
@ 32,48 SAY FPFEMP PICTURE "9,99,999"
@ 33,1 SAY "No. of employees not under P.F./F.P.F."
@ 33,48 SAY RECCOUNT()-FPFEMP PICTURE "9,99,999"
eject
