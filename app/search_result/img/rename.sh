a=0
for i in *.jpg; do
  new=$(printf "%d.jpg" ${a}) #04 pad to length of 4
  echo ${i}
  echo ${new}
  mv ${i} ${new}
  let a=a+1
done
