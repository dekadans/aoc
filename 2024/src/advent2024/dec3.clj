(ns advent2024.dec3
  (:require [clojure.java.io :as io]))

(defn -main []
    (def file-content (slurp (io/resource "dec3.txt")))

    (defn extract-part1 [s]
      (re-seq #"mul\((\d+),(\d+)\)" s))

    (defn multiply [factors]
      (->> factors
           (map #(Integer/parseInt %))
           (reduce *)))

    (def result1 (->> file-content
                  (extract-part1)
                  (map rest)
                  (map multiply)
                  (reduce +)))

    (defn extract-part2 [s]
      (re-seq #"do\(\)|don't\(\)|mul\((\d+),(\d+)\)" s))

    (def state (atom true))

    (defn run-part2-statement [s]
      (let [operation (first s)
            factors (rest s)]
        (case operation
          "do()" (reset! state true)
          "don't()" (reset! state false)
          (cond
            (true? @state) (multiply factors)))))

    (def result2 (->> file-content
                  (extract-part2)
                  (map run-part2-statement)
                  (filter integer?)
                  (reduce +)))

    (println result1 result2))