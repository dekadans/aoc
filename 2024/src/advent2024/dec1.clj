(ns advent2024.dec1)

(require '[clojure.java.io :as io])


(defn -main []

    (defn extract-numbers [s]
      (map #(Integer/parseInt %) (re-seq #"\d+" s)))

    (def file-content (->> (slurp (io/resource "dec1.txt"))
                           (clojure.string/split-lines)
                           (map extract-numbers)))

    (def first-seq (->> file-content
                        (map first)
                        (sort)))

    (def sec-seq (->> file-content
                      (map rest)
                      (flatten)
                      (sort)))

    (def result (->> (map - first-seq sec-seq)
                     (map abs)
                     (reduce +)))

    (println result)

    (def grouped-by-value (partition-by identity sec-seq))
    (def value-count-map (zipmap (map first grouped-by-value) (map count grouped-by-value)))

    (def result2 (->> first-seq
                      (map #(get value-count-map % 0))
                      (map * first-seq)
                      (reduce +)))

    (println result2))