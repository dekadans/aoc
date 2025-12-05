(ns advent2024.dec4
  (:require [clojure.java.io :as io]
            [clojure.string :as str]
            [clojure.set :as set]))

(defn -main []
    ;; The main word search matrix
    (def matrix (->> (slurp (io/resource "dec4.txt"))
                     (str/split-lines)
                     (map vec)
                     (vec)))

    (def row_count (count matrix))
    (def col_count (count (first matrix)))

    ;; Traverse the matrix diagonally
    (defn get-diagonal [start-row start-col step-row step-col]
      (loop [row start-row
             col start-col
             result []]
        (if (and (>= row 0) (< row row_count)
                 (>= col 0) (< col col_count))
          (recur (+ row step-row)
                 (+ col step-col)
                 ; We add the letter and coordinates (for part 2)
                 (conj result [(get-in matrix [row col]) row col]))
          result)))

    ;; Matrix flipped 90 deg, for looking in columns
    (def matrix_flipped (apply map list matrix))

    ;; Diagonals in one direction
    (def diagonals1 (concat
                      (for [start-row (range row_count)]
                        (get-diagonal start-row 0 -1 1))
                      (for [start-col (range 1 col_count)]
                        (get-diagonal (dec row_count) start-col -1 1))))

    ;; Diagonals in the other direction
    (def diagonals2 (concat
                      (for [start-row (range row_count)]
                        (get-diagonal start-row 0 1 1))
                      (for [start-col (range 1 col_count)]
                        (get-diagonal 0 start-col 1 1))))


    ;; Remove coordinates for part 1 diagonals
    (def part1-diagonals (->> (concat diagonals1 diagonals2)
                              (map #(map first %))))

    ;; For part 1 we just search for XMAS in each char sequence (and its reverse)
    (defn part1-xmas-finder [char-list]
      (->> [char-list (reverse char-list)]
           (map (fn [xmas?]
                  (->> xmas?
                       (apply str)
                       (re-seq #"XMAS")
                       (count))))
           (reduce +)))

    (println (->> [matrix matrix_flipped part1-diagonals]
                  (mapcat #(map part1-xmas-finder %))
                  (reduce +)))

    ;; For part 2 we search the diagonals for MAS or SAM and store the coords for the A
    (defn part2-find-mas [diag]
      (let [mas (seq "MAS")
            sam (seq "SAM")]
        (->> diag
             (map first)
             (partition 3 1)
             (map-indexed vector)
             (filter (fn [t]
                       (let [three-letters (second t)]
                         (or (= three-letters mas) (= three-letters sam)))))
             (map first)
             (map inc)
             (map #(get diag %)))))

    (def diagonal-mas-1 (->> diagonals1
                      (mapcat part2-find-mas)
                      (set)))

    (def diagonal-mas-2 (->> diagonals2
                      (mapcat part2-find-mas)
                      (set)))

    ;; A's that appear in both diagonals indicate an X-MAS occurrence!
    (println (->> [diagonal-mas-1 diagonal-mas-2]
                  (apply set/intersection)
                  (count))))
