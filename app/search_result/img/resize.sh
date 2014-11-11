for i in *.jpg; do
  convert ${i} -resize 150x150\! ${i}
done
