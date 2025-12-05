(ns advent2024.dec2
  (:require [clojure.java.io :as io]
            [clojure.string :as str]))


(defn -main []
    (defn extract-numbers [s]
      (map #(Integer/parseInt %) (re-seq #"\d+" s)))

    (def file-content (->> (slurp (io/resource "dec2.txt"))
                           (str/split-lines)
                           (map extract-numbers)))

    (defn get-deltas [numbers]
      (map - (rest numbers) numbers))

    (defn eval-report [report]
      (let [deltas (get-deltas report)
            trends (->> deltas
                      (filter #(not (zero? %)))
                      (filter #(<= (abs %) 3))
                      (partition-by pos?))
            consistent (= (count trends) 1)
            unfiltered (= (count (first trends)) (count deltas))]

        (and (true? consistent) (true? unfiltered))))


    (def result1 (->> file-content
              (map eval-report)
              (filter true?)
              (count)))

    (println result1)

    (defn dampener [report]
      (let [iterator (range (count report))]
        (map (fn [i] (concat (take i report) (drop (inc i) report))) iterator)))

    (defn eval-with-dampener [report]
      (let [options (conj (dampener report) report)]
        (->> options
             (map eval-report)
             (drop-while false?))))

    (def result2 (->> file-content
                  (map eval-with-dampener)
                  (filter not-empty)
                  (count)))

    (println result2))