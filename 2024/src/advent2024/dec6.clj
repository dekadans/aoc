; This file is not a complete solution for Day 6

(ns advent2024.dec6
  (:require [clojure.java.io :as io]
            [clojure.string :as str]))


(defn -main []
    (def data (->> "dec6.txt"
                   (io/resource)
                   (slurp)
                   (str/split-lines)
                   (mapv vec)))

    (defn find-guard [grid]
      (loop [i 0]
        (let [row (apply str (get grid i))
              guard? (str/index-of row "^")]
          (if (and guard? (> guard? -1))
            [i guard?]
            (recur (inc i))))))

    (def steps {:up [-1 0] :right [0 1] :down [1 0] :left [0 -1]})
    (def turn {:up :right :right :down :down :left :left :up})

    (def start-pos (find-guard data))

    (defn walk-guard [block-override]
      (loop [current start-pos
             direction :up
             path #{[current direction]}]
        (let [next-pos (mapv + current (get steps direction))
              next-val (if (= next-pos block-override) \# (get-in data next-pos))
              to-store [next-pos direction]]
          (if (contains? path to-store)
            (do
              (println block-override current direction)
              nil)
            (case next-val
              nil path
              \# (recur current (get turn direction) path)
              (recur next-pos direction (conj path to-store))))
          )
        ))
    ; (get-in data next-pos)

    (defn find-loop-options [path]
      (loop [to-evaluate path
             found []]
        (let [evaluating (first to-evaluate)
              position (first evaluating)
              direction (second evaluating)
              next-pos (mapv + position (get steps direction))
              is-already-blocked? (= \# (get-in data next-pos))]
          (println "eval:" evaluating "next:" next-pos)
          ;(println [position direction]  (and loop? (not is-already-blocked?)))
          ;(println (walk-guard next-pos))
          (if (empty? to-evaluate)
            found
            (if (not is-already-blocked?)
              (recur (rest to-evaluate) (if (nil? (walk-guard next-pos)) (conj found next-pos) found ))
              (recur (rest to-evaluate) found))))))


    (def path-data (walk-guard nil))

    (println (->> path-data
                  (map first)
                  (set)
                  (count)))

    (println (->> path-data
                  (find-loop-options))))