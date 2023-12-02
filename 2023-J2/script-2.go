package main

import (
	"fmt"
	"io/ioutil"
	"regexp"
	"strconv"
	"strings"
)

func main() {
	input, err := ioutil.ReadFile("./data.txt")
	if err != nil {
		panic("Cant read data file")
	}

	rows := strings.Split(string(input), "\n")
	results := make([]int, 0)

	for _, row := range rows {
		parts := strings.Split(row, ": ")
		valuesAsText := parts[1]

		matches := regexp.MustCompile(`(\d+)\s*([a-zA-Z]+)`).FindAllStringSubmatch(valuesAsText, -1)

		gameData := make(map[string]int)
		for _, match := range matches {
			count, _ := strconv.Atoi(match[1])
			color := strings.ToLower(match[2])

			if _, ok := gameData[color]; !ok {
                gameData[color] = 0
            }

            if count > gameData[color] {
                gameData[color] = count
            }
		}

        results = append(results, gameData["red"]*gameData["green"]*gameData["blue"])
	}

	sum := 0
	for _, result := range results {
		sum += result
	}

	fmt.Println(sum)
}
