(ns advent2024.dec5
  (:require [clojure.java.io :as io]
            [clojure.string :as str]))

(defn -main []
    ;; Function definitions

    (defn extract-numbers [s]
      "Helper to find and parse integers in a string"
      (mapv #(Integer/parseInt %) (re-seq #"\d+" s)))


    (defn make-rule-map [r]
      "Restructure the rules into a dictionary {x: [y, z]}"
      (loop [result {}
             input r]
        (let [active (first input)
              remain (rest input)]
          (if active
            (let [key (first active)
                  value (second active)
                  wrapped-value (condp contains? key
                                  result (conj (get result key) value)
                                  #{value})]
              (recur (assoc result key wrapped-value) remain))
            result))))

    (defn evaluate-update-order [rule-map all-updates]
      "Evaluate order by sorting and comparing to the original"
      (let [comparer (fn [a b]
                       (let [active-rules (get rule-map a #{})]
                         (contains? active-rules b)))]
        (loop [to-evaluate all-updates
               valid []
               invalid []]
          (if (not-empty to-evaluate)
            (let [current (first to-evaluate)
                  sorted (sort comparer current)]
              (if (= current sorted)
                (recur (rest to-evaluate) (conj valid current) invalid)
                (recur (rest to-evaluate) valid (conj invalid sorted))))
            {:valid valid :invalid invalid}))))

    (defn middle-sum [page-seq]
      "Adds all values in the middle position of a vector"
      (->> page-seq
           (map (fn [v]
                  (nth v (quot (count v) 2))))
           (reduce +)))

    ;; Execution

    (def data (-> "dec5.txt"
                  (io/resource)
                  (slurp)
                  (str/split #"\n\n")
                  (->>
                    (map #(str/split-lines %)))))

    (def rules (make-rule-map (->> data
                                   (first)
                                   (map extract-numbers))))

    (def updates-to-print (->> data
                               (second)
                               (map extract-numbers)
                               (evaluate-update-order rules)))

    (println "Part 1:" (-> updates-to-print
                           (get :valid)
                           (middle-sum)))

    (println "Part 2:" (-> updates-to-print
                           (get :invalid)
                           (middle-sum))))
